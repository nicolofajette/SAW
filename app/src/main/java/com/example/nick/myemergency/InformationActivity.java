package com.example.nick.myemergency;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.support.v4.app.FragmentActivity;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.widget.TabHost;
import android.widget.Toast;

import com.google.tabmanager.TabManager;

import java.util.ArrayList;

public class InformationActivity extends FragmentActivity {
    TabHost tabHost;
    TabManager tabManager;
    MyEmergencyDB db;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_information);

        // get database
        db = new MyEmergencyDB(getApplicationContext());

        // get tab manager
        tabHost = (TabHost) findViewById(android.R.id.tabhost);
        tabHost.setup();
        tabManager = new TabManager(this, tabHost, R.id.realtabcontent);


        TabHost.TabSpec tabSpec = tabHost.newTabSpec("Informazioni");
        tabSpec.setIndicator("Informazioni");
        tabManager.addTab(tabSpec, InformationFragment.class, null);
        TabHost.TabSpec tabSpec1 = tabHost.newTabSpec("Eventi");
        tabSpec1.setIndicator("Eventi");
        tabManager.addTab(tabSpec1, EventFragment.class, null);

        Intent intent = getIntent();
        Bundle extras = getIntent().getExtras();
        if (extras != null && extras.getInt("notifica") == 1) {
            tabHost.setCurrentTabByTag("Eventi");
        }

        // sets current tab to the last tab opened
        if (savedInstanceState != null) {
            tabHost.setCurrentTabByTag(savedInstanceState.getString("tab"));
        }

    }

    @Override
    protected void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        outState.putString("tab", tabHost.getCurrentTabTag());
    }

    @Override
    public void onPause () {
        super.onPause();
    }

    @Override
    public void onResume () {
        super.onResume();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.activity_task_list, menu);
        return true;
    }
}
