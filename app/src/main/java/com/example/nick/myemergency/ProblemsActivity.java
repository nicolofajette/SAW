package com.example.nick.myemergency;


import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;

public class ProblemsActivity extends Activity {
    private static String FILENAME = "response_temp.txt";   //Nome file in cui salvare temporaneamente la risposta XML dal server

    private CheckBox checkBox1;
    private CheckBox checkBox2;
    private CheckBox checkBox3;
    private CheckBox checkBox4;
    private CheckBox checkBox5;
    private CheckBox checkBox6;
    private CheckBox checkBox7;
    private CheckBox checkBox8;
    private CheckBox checkBox9;
    private CheckBox checkBox10;
    private TextView textView1;
    private TextView textView2;
    private TextView textView3;
    private TextView textView4;
    private TextView textView5;
    private TextView textView6;
    private TextView textView7;
    private TextView textView8;
    private TextView textView9;
    private TextView textView10;
    private Button  sendButton;

    private MyEmergencyDB db;
    private ArrayList<Problem> problems;

    // get edit mode from intent
    Intent intent = getIntent();

    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.problems);

        // get references to widgets
        CheckBox[] checkBoxs = new CheckBox[10];
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
        TextView[] textViews = new TextView[10];
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


        /*sendButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                HashMap<String, String> emergenza;  //Deve contenere una coppia chiave valore dei dati da passare in post.
                new SendRequest(getApplicationContext(), FILENAME).execute(emergenza);
                this.finish();
            }
        });*/
    }
}
