package com.example.nick.myemergency;

import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.os.AsyncTask;
import android.preference.PreferenceManager;
import android.support.v4.app.NotificationCompat;
import android.telephony.SmsManager;
import android.util.Log;
import android.widget.Toast;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.text.DateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.net.ssl.HttpsURLConnection;


public class SendRequest extends AsyncTask<HashMap<String, String>, Void, String> {
    EmergencyRequest request;
    private static String URL_STRING = "http://webdev.dibris.unige.it/~S4078757/PAA/emergencyHandler.php";
    private String filename;
    private Information information;
    private String problemstring;
    Context context;
    private MyEmergencyDB db;

    // define messages constants
    private final int MESSAGES_NONE = 0;
    private final int MESSAGES_NORMAL = 1;
    private final int MESSAGES_WHATSAPP = 2;

    private SharedPreferences prefs;
    private int messages_type = MESSAGES_NONE;

    public SendRequest(Context context, String filename, Information information, String problemstring){
        this.context = context;
        this.filename = filename;
        this.information = information;
        this.problemstring = problemstring;
    }

    @Override
    protected String doInBackground(HashMap<String, String>... params){
        URL url;
        String response = "";
        HashMap<String, String> postDataParams = params[0];
        try{
            url = new URL(URL_STRING);
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            //HttpsURLConnection conn = (HttpsURLConnection) url.openConnection();
            conn.setReadTimeout(15000);
            conn.setConnectTimeout(15000);
            conn.setRequestMethod("POST");
            conn.setDoInput(true);
            conn.setDoOutput(true);
            OutputStream os = conn.getOutputStream();
            BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(os, "UTF-8"));
            writer.write(getPostDataString(postDataParams));    //Scrivo i dati in post da inviare
            writer.flush();
            writer.close();
            os.close();
            int responseCode = conn.getResponseCode();
            if(responseCode == HttpURLConnection.HTTP_OK){
                String line;
                FileOutputStream out = context.openFileOutput(filename, Context.MODE_PRIVATE);
                InputStream in = conn.getInputStream();
                byte[] buffer = new byte[1024];
                int bytesRead = in.read(buffer);
                while(bytesRead != -1){
                    out.write(buffer, 0, bytesRead);
                    bytesRead = in.read(buffer);
                }
                out.close();
                in.close();
                /*BufferedReader br = new BufferedReader(new InputStreamReader(conn.getInputStream()));
                while((line = br.readLine()) != null){
                    response += line;
                }*/
                return "Success";
            }else{
                return "HTTP err";
            }
        } catch (Exception e){
            Log.e("CONN_ERR", e.toString());
            return "Errore: " + e.toString();    //Restituisco l'errore ricevuto
        }
    }

    //Funzione che a partire dall'hash map dei parametri li converte in una stringa per la richiesta post
    private String getPostDataString(HashMap<String, String> params) throws UnsupportedEncodingException{
        StringBuilder result = new StringBuilder();
        boolean first = true;
        for(Map.Entry<String, String> entry : params.entrySet()){
            if(first){
                first = false;
            }else{
                result.append("&");
            }
            result.append(URLEncoder.encode(entry.getKey(), "UTF-8"));
            result.append("=");
            result.append(URLEncoder.encode(entry.getValue(), "UTF-8"));
        }
        return result.toString();
    }

    protected void onPostExecute(String result){
        //Inserire cosa fare dopo l'invio della richiesta di soccorso
        if(result.equals("Success")){
            //Invio richiesta avvenuta con successo
            db = new MyEmergencyDB(context);
            Information possessor = db.getInformation(1);
            Evento event = new Evento();
            event.setType("INVIATO");
            event.setName(information.getName() + " " + information.getSurname());
            String currentDateTimeString = DateFormat.getDateTimeInstance().format(new Date());
            event.setTime(currentDateTimeString);
            db.insertEvent(event);
            // get default SharedPreferences object
            prefs = PreferenceManager.getDefaultSharedPreferences(context);
            messages_type = Integer.parseInt(prefs.getString("pref_messages", "0"));
            String text = "E' stata inviata una richiesta di emergenza per " + information.getName() + " " + information.getSurname() + " con queste problematiche: " + problemstring + "dal cellulare di " + possessor.getName() + " " + possessor.getSurname();
            if (context.getPackageManager().hasSystemFeature(PackageManager.FEATURE_TELEPHONY)) {
                if (messages_type == MESSAGES_NORMAL) {
                    if (information.getContact1() != null && !information.getContact1().equals("") && information.getContact1().length() > 1) {
                        sendSMS(information.getContact1(), text);
                    }
                    if (information.getContact2() != null && information.getContact2().equals("") && information.getContact2().length() > 1) {
                        sendSMS(information.getContact2(), text);
                    }
                } else if (messages_type == MESSAGES_WHATSAPP) {
                    if (information.getContact1() != null && !information.getContact1().equals("") && information.getContact1().length() > 1) {
                        String smsNumber = "39"+information.getContact1();
                        Intent sendIntent = new Intent("android.intent.action.MAIN");
                        //sendIntent.setComponent(new ComponentName("com.whatsapp", "com.whatsapp.Conversation"));
                        sendIntent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                        sendIntent.setAction(Intent.ACTION_SEND);
                        sendIntent.setType("text/plain");
                        sendIntent.putExtra(Intent.EXTRA_TEXT, text);
                        sendIntent.putExtra("jid", smsNumber + "@s.whatsapp.net");
                        sendIntent.setPackage("com.whatsapp");
                        context.startActivity(sendIntent);
                    }
                }
            } else {
                //errore
            }
            sendNotification(true);
        }else{
            sendNotification(false);
        }
        Log.d("Esito connessione", result);
        new FetchResponse(context).execute(filename);
    }

    public void sendNotification(Boolean condition) {

        NotificationCompat.Builder mBuilder =
                new NotificationCompat.Builder(context);
        mBuilder.setAutoCancel(true);

        //Create the intent that’ll fire when the user taps the notification//
        Intent intent = new Intent(context, InformationActivity.class);
        intent.putExtra("notifica", 1);
        PendingIntent pendingIntent = PendingIntent.getActivity(context, 0, intent, PendingIntent.FLAG_UPDATE_CURRENT | PendingIntent.FLAG_ONE_SHOT);

        mBuilder.setContentIntent(pendingIntent);

        mBuilder.setSmallIcon(R.drawable.ic_launcher);
        if (condition) {
            mBuilder.setContentTitle("Richiesta inviata");
            mBuilder.setContentText("Le risponderemo al più presto");
        } else {
            mBuilder.setContentTitle("Richiesta non inviata");
            mBuilder.setContentText("Errore nell'invio della richiesta");
        }

        NotificationManager mNotificationManager =

                (NotificationManager) context.getSystemService(Context.NOTIFICATION_SERVICE);

        mNotificationManager.notify(001, mBuilder.build());
    }

    public void sendSMS(String phoneNo, String msg) {
        try {
            SmsManager smsManager = SmsManager.getDefault();
            smsManager.sendTextMessage(phoneNo, null, msg, null, null);
            Toast.makeText(context, "Messagio Inviato",
                    Toast.LENGTH_LONG).show();
        } catch (Exception ex) {
            Toast.makeText(context,ex.getMessage().toString(),
                    Toast.LENGTH_LONG).show();
            ex.printStackTrace();
        }
    }
}