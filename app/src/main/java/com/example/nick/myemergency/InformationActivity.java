package com.example.nick.myemergency;

import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.TabHost;

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

        // get tab manager
        tabHost = (TabHost) findViewById(android.R.id.tabhost);
        tabHost.setup();
        tabManager = new TabManager(this, tabHost, R.id.realtabcontent);

        // get database
        db = new MyEmergencyDB(getApplicationContext());
        TabHost.TabSpec tabSpec = tabHost.newTabSpec("Informazioni");
        tabSpec.setIndicator("Informazioni");
        tabManager.addTab(tabSpec, InformationFragment.class, null);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_task_list, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()){
            case R.id.menuAddTask:
                Intent intent = new Intent(this, AddEditActivity.class);
                startActivity(intent);
                break;
            case R.id.menuDelete:
                // Hide all tasks marked as cancel
                ArrayList<Information> informations = db.getInformations();
                for (Information information : informations){
                    if (information.getCancelDateMillis() > 0){
                        information.setHidden(Information.TRUE);
                        db.updateInformation(information);
                    }
                }
                // Refresh list
                InformationFragment currentFragment = (InformationFragment)
                        getSupportFragmentManager().
                                findFragmentByTag(tabHost.getCurrentTabTag());
                currentFragment.refreshTaskList();

                break;
        }
        return super.onOptionsItemSelected(item);
    }
}
