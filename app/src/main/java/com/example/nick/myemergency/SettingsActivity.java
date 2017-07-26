package com.example.nick.myemergency;

import android.app.ActionBar;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;

public class SettingsActivity extends Activity {

    private boolean firstTime;
    Boolean state = false;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        Intent intent = getIntent();
        firstTime = intent.getBooleanExtra("first", false);
        if (!firstTime) {
            state = true;
            ActionBar actionBar = getActionBar();
            actionBar.setDisplayHomeAsUpEnabled(true);
            actionBar.setHomeAsUpIndicator(R.drawable.ic_menu_back);
            invalidateOptionsMenu();
        }

        // Set the view for the activity using XML
        setContentView(R.layout.activity_settings);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_settings, menu);
        if (state == true)
        {
            menu.findItem(R.id.menuSave).setVisible(false);
        }
        return true;
    }

    public boolean onOptionsItemSelected(MenuItem item){
        switch (item.getItemId()) {
            case android.R.id.home:
                Intent myIntent = new Intent(getApplicationContext(), InformationActivity.class);
                startActivityForResult(myIntent, 0);
                break;
            case R.id.menuSave:
                Intent intent = new Intent(this, AddEditActivity.class);
                intent.putExtra("first", true);
                startActivity(intent);
        }
        return true;

    }

    public Boolean getFirstTime() {
        return firstTime;
    }

}
