package com.example.nick.myemergency;

import android.app.NotificationManager;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.media.RingtoneManager;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.NotificationCompat;

import com.google.android.gms.gcm.GoogleCloudMessaging;

public class NotificationReceiver extends BroadcastReceiver {
    public static final int NOTIFICATION_ID = 1;
    private NotificationManager notificationManager;
    NotificationCompat.Builder builder;

    public NotificationReceiver(){

    }

    @Override
    public void onReceive(Context context, Intent intent) {
        GoogleCloudMessaging gcm = GoogleCloudMessaging.getInstance(context);
        Bundle extras = intent.getExtras();

        String messageType = gcm.getMessageType(intent);
        if(!extras.isEmpty()){
            if(GoogleCloudMessaging.MESSAGE_TYPE_MESSAGE.equals(messageType)){
                //Emetti notifica
                sendNotification(context, "notifica");
            }
        }
    }

    private void sendNotification(Context context, String msg){
        notificationManager = (NotificationManager) context.getSystemService(Context.NOTIFICATION_SERVICE);
        Uri sound = RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION);   //Suoneria notifica
        NotificationCompat.Builder builder = new NotificationCompat.Builder(context).setContentTitle("MyEmergency").setContentText(msg).setSound(sound);
        notificationManager.notify(NOTIFICATION_ID, builder.build());
    }
}