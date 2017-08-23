package com.example.nick.myemergency;

import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;

public class TutorialActivity extends FragmentActivity {

    private Boolean tutorial = false;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.tutorial_activity);

        if(getResources().getBoolean(R.bool.landscape_only)){
            setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE);
        }

        Intent intent = getIntent();
        tutorial = intent.getBooleanExtra("tutorial", false);

        if (findViewById(R.id.fragment_container) != null) {
            if (!tutorial) {
                TutorialFragment1 firstFragment = new TutorialFragment1();
                getSupportFragmentManager().beginTransaction()
                        .add(R.id.fragment_container, firstFragment).commit();
            } else {
                Bundle bundle = new Bundle();
                bundle.putBoolean("tutorial", true);
                TutorialFragment2 firstFragment = new TutorialFragment2();
                firstFragment.setArguments(bundle);
                getSupportFragmentManager().beginTransaction()
                        .add(R.id.fragment_container, firstFragment).commit();
            }
        }
    }
}
