package com.example.nick.myemergency;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.widget.Toast;

public class FistLaunch extends Activity {
    SharedPreferences sharedPreferences;
    MyEmergencyDB db;
    @Override
    public void onCreate(Bundle icicle) {
        super.onCreate(icicle);
        // get database
        db = new MyEmergencyDB(getApplicationContext());

        sharedPreferences = getSharedPreferences("ShaPreferences", Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        boolean  firstTime = sharedPreferences.getBoolean("first", true);
        if(firstTime || !db.testNotEmpty()) {
            editor.putBoolean("first",false);
            editor.commit();
            Intent intent = new Intent(this,  SettingsActivity.class);
            intent.putExtra("first", true);
            startActivity(intent);
            finish();
        }
        else {
            Intent intent = new Intent(this, InformationActivity.class);
            startActivity(intent);
            finish();
        }

    }
}

