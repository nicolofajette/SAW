package com.example.nick.myemergency;


import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationManager;
import android.os.Bundle;
import android.provider.Settings;
import android.support.v4.app.ActivityCompat;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.tasks.OnSuccessListener;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;

public class ProblemsActivity extends Activity {
    private static String FILENAME = "response_temp.txt";   //Nome file in cui salvare temporaneamente la risposta XML dal server

    private TextView tittleTextView;
    private Button sendButton;

    private MyEmergencyDB db;
    private ArrayList<Problem> problems;
    private Location position;
    private String problemstring = "";

    private FusedLocationProviderClient mFusedLocationClient;

    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.problems);

        // get infoId mode from intent
        Intent intent = getIntent();
        final long informationId = intent.getLongExtra("informationId", -1);

        mFusedLocationClient = LocationServices.getFusedLocationProviderClient(this);
        if (ActivityCompat.checkSelfPermission(this, android.Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, android.Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions
            // here to request the missing permissions, and then overriding
            //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
            //                                          int[] grantResults)
            // to handle the case where the user grants the permission. See the documentation
            // for ActivityCompat#requestPermissions for more details.
            return;
        }
        mFusedLocationClient.getLastLocation().addOnSuccessListener(this, new OnSuccessListener<Location>() {
            @Override
            public void onSuccess(Location location) {
                // Got last known location. In some rare situations this can be null.
                if (location != null) {
                    position = location;
                    tittleTextView.setText(Double.toString(location.getLatitude())+","+Double.toString(location.getLongitude()));
                }
            }
        });

        // get references to widgets
        tittleTextView = (TextView) findViewById(R.id.titleTextView);
        final CheckBox[] checkBoxs = new CheckBox[10];
        checkBoxs[0] = (CheckBox) findViewById(R.id.CheckBox1);
        checkBoxs[1] = (CheckBox) findViewById(R.id.CheckBox2);
        checkBoxs[2] = (CheckBox) findViewById(R.id.CheckBox3);
        checkBoxs[3] = (CheckBox) findViewById(R.id.CheckBox4);
        checkBoxs[4] = (CheckBox) findViewById(R.id.CheckBox5);
        checkBoxs[5] = (CheckBox) findViewById(R.id.CheckBox6);
        checkBoxs[6] = (CheckBox) findViewById(R.id.CheckBox7);
        checkBoxs[7] = (CheckBox) findViewById(R.id.CheckBox8);
        checkBoxs[8] = (CheckBox) findViewById(R.id.CheckBox9);
        checkBoxs[9] = (CheckBox) findViewById(R.id.CheckBox10);
        final TextView[] textViews = new TextView[10];
        textViews[0] = (TextView) findViewById(R.id.TextView1);
        textViews[1] = (TextView) findViewById(R.id.TextView2);
        textViews[2] = (TextView) findViewById(R.id.TextView3);
        textViews[3] = (TextView) findViewById(R.id.TextView4);
        textViews[4] = (TextView) findViewById(R.id.TextView5);
        textViews[5] = (TextView) findViewById(R.id.TextView6);
        textViews[6] = (TextView) findViewById(R.id.TextView7);
        textViews[7] = (TextView) findViewById(R.id.TextView8);
        textViews[8] = (TextView) findViewById(R.id.TextView9);
        textViews[9] = (TextView) findViewById(R.id.TextView10);
        sendButton = (Button) findViewById(R.id.SendButton);

        // get the database object
        db = new MyEmergencyDB(this);

        problems = db.getProblems();

        Iterator iterator = problems.iterator();
        int i=0;
        while (iterator.hasNext()) {
           Problem problem =(Problem) iterator.next();
            textViews[i].setText(problem.getName());
            i++;
        }

        sendButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (sendChecked(checkBoxs)) {
                    HashMap<String, String> emergenza = new HashMap<String, String>();  //Deve contenere una coppia chiave valore dei dati da passare in post.
                    Information information = db.getInformation(informationId);
                    emergenza.put("nome", information.getName());
                    emergenza.put("cognome", information.getSurname());
                    emergenza.put("data_nascita", information.getDate_of_birth());
                    emergenza.put("codice_fiscale", information.getCodiceFiscale());
                    emergenza.put("cellulare", information.getTelephone());
                    if (position != null) {
                        String coordinate = String.valueOf(position.getLatitude()) + ", " + String.valueOf(position.getLongitude());
                        emergenza.put("coordinate", coordinate);  //TODO: aggiungere coordinate
                    }
                    Iterator iterator = problems.iterator();
                    int i = 0;
                    String sintomi = "";
                    boolean first = true;
                    while (iterator.hasNext()) {  //TODO: valutare se modificare sostituendo con xml element
                        Problem problem = (Problem) iterator.next();
                        if (checkBoxs[i].isChecked()) {
                            //emergenza.put("sintomi[]", problem.getName());
                            if(first){
                                first = false;
                            }else{
                                sintomi += ", ";
                            }
                            sintomi += problem.getName();
                            problemstring += problem.getName() + ", ";
                        }
                        i++;
                    }
                    emergenza.put("sintomi", sintomi);
                    new SendRequest(getApplicationContext(), FILENAME, information, problemstring).execute(emergenza);
                    ProblemsActivity.this.finish();
                }
            }
        });
    }

    public boolean sendChecked(CheckBox[] checkBoxs) {
        for (int i=0; i<checkBoxs.length; i++) {
            if (checkBoxs[i].isChecked()) {
                return true;
            }
        }
        return false;
    }

    @Override
    public void onResume(){
        super.onResume();
        mFusedLocationClient = LocationServices.getFusedLocationProviderClient(this);
        if (ActivityCompat.checkSelfPermission(this, android.Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, android.Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions
            // here to request the missing permissions, and then overriding
            //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
            //                                          int[] grantResults)
            // to handle the case where the user grants the permission. See the documentation
            // for ActivityCompat#requestPermissions for more details.
            return;
        }
        mFusedLocationClient.getLastLocation().addOnSuccessListener(this, new OnSuccessListener<Location>() {
            @Override
            public void onSuccess(Location location) {
                // Got last known location. In some rare situations this can be null.
                if (location != null) {
                    position = location;
                    tittleTextView.setText(Double.toString(location.getLatitude())+","+Double.toString(location.getLongitude()));
                }
            }
        });

    }
}