package com.example.nick.myemergency;


import android.app.Activity;
import android.os.Bundle;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.Iterator;

public class ProblemsActivity extends Activity {

    private TextView problemsTextView;

    private MyEmergencyDB db;
    private ArrayList<Problem> problems;

    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.problems);

        // get references to widgets
        problemsTextView = (TextView) findViewById(R.id.problemsTextView);

        // get the database object
        db = new MyEmergencyDB(this);

        problems = db.getProblems();

        String text="";
        Iterator iterator = problems.iterator();
        while (iterator.hasNext()) {
           Problem problem =(Problem) iterator.next();
           text = text + problem.getName() + ", " ;
        }

        problemsTextView.setText(text);
    }
}
