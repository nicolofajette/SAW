package com.example.nick.myemergency;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.widget.Toast;

import com.google.android.gms.gcm.GoogleCloudMessaging;

import java.io.IOException;

/**
 * Created by Nick on 30/07/2017.
 */

public class GCMRegistration {
    private static final String BACKEND_URL = "https://webdev.dibris.unige.it/~S4078757/PAA/register.php";
    String SENDER_ID = "820395077738";  //Project number

    GoogleCloudMessaging gcm;
    Context context;
    String regid;

    public GCMRegistration(Context context){
        this.context = context;
        gcm = GoogleCloudMessaging.getInstance(context);
        if(checkRegidAlreadySaved() == false) {
            registerInBackground();
        }else{
            loadRegid();
        }
    }

    private void registerInBackground(){
        new AsyncTask<Void, Void, String>(){
            private ProgressDialog dialog = null;

            protected void onPreExecute(){
                dialog = ProgressDialog.show(context, "Registrazione presso CGM", "Tentativo in corso..", true, false);
            };

            @Override
            protected String doInBackground(Void... params){
                String msg = "";
                try{
                    if(gcm == null){
                        gcm = GoogleCloudMessaging.getInstance(context);
                    }
                    regid = gcm.register(SENDER_ID);
                }catch (IOException e){
                    return null;
                }
                return regid;
            }

            @Override
            protected void onPostExecute(String regid){
                dialog.dismiss();
                if(regid != null){
                    saveRegId(regid);
                }else{
                    Toast.makeText(context, "Errore registrazione GCM.", Toast.LENGTH_LONG);
                }
            }
        }.execute();
    }

    private boolean saveRegId(String regid){
        if(regid != null){
            SharedPreferences sharedPreferences = context.getSharedPreferences("ShaPreferences", Context.MODE_PRIVATE);
            SharedPreferences.Editor editor = sharedPreferences.edit();
            String shared_regid = sharedPreferences.getString("regid", null);
            if(shared_regid == null){
                //Nessun regid precedentemente salvato
                editor.putString("regid", regid);
                editor.apply();
                return true;
            }
        }
        return false;
    }

    private boolean checkRegidAlreadySaved(){
        SharedPreferences sharedPreferences = context.getSharedPreferences("ShaPreferences", Context.MODE_PRIVATE);
        String shared_regid = sharedPreferences.getString("regid", null);
        if(shared_regid == null){
            return false;
        }else{
            return true;
        }
    }

    private void loadRegid(){
        SharedPreferences sharedPreferences = context.getSharedPreferences("ShaPreferences", Context.MODE_PRIVATE);
        regid = sharedPreferences.getString("regid", null);
    }

    public String getRegid(){
        return regid;
    }
}
