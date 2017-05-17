package com.example.nick.myemergency;

import android.content.Context;
import android.os.AsyncTask;
import android.util.Log;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.net.ssl.HttpsURLConnection;

/**
 * Created by Nick on 05/05/2017.
 */

public class SendRequest extends AsyncTask<HashMap<String, String>, Void, String> {
    EmergencyRequest request;
    private static String URL_STRING = "miosito.it";

    @Override
    protected String doInBackground(HashMap<String, String>... params){
        URL url;
        String response = "";
        HashMap<String, String> postDataParams = params[0];
        try{
            url = new URL(URL_STRING);
            //HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            HttpsURLConnection conn = (HttpsURLConnection) url.openConnection();
            conn.setReadTimeout(15000);
            conn.setConnectTimeout(15000);
            conn.setRequestMethod("POST");
            conn.setDoInput(true);
            conn.setDoOutput(true);
            OutputStream os = conn.getOutputStream();
            BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(os, "UTF-8"));
            writer.write(getPostDataString(postDataParams));
            writer.flush();
            writer.close();
            os.close();
            int responseCode = conn.getResponseCode();
            if(responseCode == HttpURLConnection.HTTP_OK){
                String line;
                BufferedReader br = new BufferedReader(new InputStreamReader(conn.getInputStream()));
                while((line = br.readLine()) != null){
                    response += line;
                }
            }else{
                response = "";
            }
        } catch (Exception e){
            Log.e("CONN_ERR", e.toString());
            return "Errore: " + e.toString();    //Restituisco l'errore ricevuto
        }
        return "Success";
        /*try {
            URL url = new URL(URL_STRING);  //Oggetto URL che rappresenta l'indirizzo
            HttpURLConnection client = (HttpURLConnection) url.openConnection();
            String datiPost = URLEncoder.encode("nome", "UTF-8") + "=" + URLEncoder.encode(request.nome, "UTF-8");
            client.setDoOutput(true);   //Per l'invio
            client.setChunkedStreamingMode(0);  //Ottimizzo gestione buffer memorizzando temporaneamente risposte dal server
            //Scrivo i dati nello stream di uscita
            OutputStreamWriter wr = new OutputStreamWriter(client.getOutputStream());
            wr.write(datiPost);
            wr.flush();
        } catch (UnsupportedEncodingException e) {
            Log.e("SendRequest", "UnsupportedEncodingException");
            return "Fail";
        }catch (IOException e){
            Log.e("SendRequest", e.toString());
            return "Fail";
        }
        return "Success";*/
    }

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
            result.append(URLEncoder.encode(entry.getKey(), "UTF-8"));
        }
        return result.toString();
    }

    protected void onPostExecute(String result){
        //Inserire cosa fare dopo l'invio della richiesta di soccorso
        if(result.equals("Success")){
            //Invio richiesta avvenuta con successo
        }else{
            //Errore
        }
    }
}