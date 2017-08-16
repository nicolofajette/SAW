package com.example.nick.myemergency;

import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.media.RingtoneManager;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.NotificationCompat;

import com.google.android.gms.gcm.GoogleCloudMessaging;

import java.text.DateFormat;
import java.util.Date;

public class NotificationReceiver extends BroadcastReceiver {
    public static long NOTIFICATION_ID = 1;
    NotificationCompat.Builder builder;
    private MyEmergencyDB db;

    public NotificationReceiver(){

    }

    @Override
    public void onReceive(Context context, Intent intent) {
        GoogleCloudMessaging gcm = GoogleCloudMessaging.getInstance(context);
        Bundle extras = intent.getExtras();
        db = new MyEmergencyDB(context);

        String messageType = gcm.getMessageType(intent);
        if(!extras.isEmpty()){
            if(GoogleCloudMessaging.MESSAGE_TYPE_MESSAGE.equals(messageType)){
                String msg = intent.getStringExtra("message");  //Messaggio inviato dal GCM
                String name_surname = intent.getStringExtra("name_surname");
                Evento event = new Evento();
                event.setType("RICHIESTA ACCETTATA");
                event.setName(name_surname);
                String currentDateTimeString = DateFormat.getDateTimeInstance().format(new Date());
                event.setTime(currentDateTimeString);
                db.insertEvent(event);
                //Emetti notifica
                sendNotification(context, msg);
            }
        }
    }


    public void sendNotification(Context context, String msg) {

        NotificationCompat.Builder mBuilder =
                new NotificationCompat.Builder(context);
        mBuilder.setAutoCancel(true);

        //Create the intent that’ll fire when the user taps the notification//
        Intent intent = new Intent(context, InformationActivity.class);
        intent.putExtra("notifica", 1);
        PendingIntent pendingIntent = PendingIntent.getActivity(context, 0, intent, PendingIntent.FLAG_UPDATE_CURRENT | PendingIntent.FLAG_ONE_SHOT);

        mBuilder.setContentIntent(pendingIntent);

        mBuilder.setSmallIcon(R.mipmap.ic_launcher);
        mBuilder.setContentTitle("Richiesta accettata");
        mBuilder.setContentText(msg);
        Uri uri = RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION); //Recupero il suono di default delle notifiche
        mBuilder.setSound(uri);

        NotificationManager mNotificationManager =

                (NotificationManager) context.getSystemService(Context.NOTIFICATION_SERVICE);

        mNotificationManager.notify(001, mBuilder.build());
    }
}