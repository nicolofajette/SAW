package com.example.nick.myemergency;


import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.CheckBox;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import java.util.HashMap;

public class InformationLayout extends RelativeLayout implements View.OnClickListener, View.OnLongClickListener {

    private CheckBox cancelCheckBox;
    private TextView nameTextView;
    private TextView surnameTextView;

    private Information information;
    private MyEmergencyDB db;
    private Context context;

    public InformationLayout(Context context) {   // used by Android tools
        super(context);
    }

    public InformationLayout(Context context, Information i) {
        super(context);

        // set context and get db object
        this.context = context;
        db = new MyEmergencyDB(context);

        // inflate the layout
        LayoutInflater inflater = (LayoutInflater)
                context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        inflater.inflate(R.layout.listview_information, this, true);

        // get references to widgets
        cancelCheckBox = (CheckBox) findViewById(R.id.cancelCheckBox);
        nameTextView = (TextView) findViewById(R.id.nameTextView);
        surnameTextView = (TextView) findViewById(R.id.surnameTextView);

        if(i.getId() == 1) {
            cancelCheckBox.setVisibility(View.INVISIBLE);
        }

        // set listeners
        cancelCheckBox.setOnClickListener(this);
        this.setOnClickListener(this);
        this.setOnLongClickListener(this);

        // set task data on widgets
        setInformation(i);
    }

    public void setInformation(Information i) {
        information = i;
        nameTextView.setText(information.getName());
        surnameTextView.setText(information.getSurname());

        if (information.getCancelDateMillis() > 0){
            cancelCheckBox.setChecked(true);
        }
        else{
            cancelCheckBox.setChecked(false);
        }
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()) {
            case R.id.cancelCheckBox:
                if (cancelCheckBox.isChecked()){
                    information.setCancelDate(System.currentTimeMillis());
                }
                else {
                    information.setCancelDate(0);
                }
                db.updateInformation(information);
                break;
            default:
                Intent intent = new Intent(context, ProblemsActivity.class);
                intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                intent.putExtra("informationId", information.getId());
                context.startActivity(intent);
                /*HashMap<String, String> hash = new HashMap<String, String>();
                hash.put("pippo","franco");
                new SendRequest().execute(hash);*/
                break;
        }
    }

    @Override
    public boolean onLongClick(View v) {
        switch (v.getId()) {
            default:
                Intent intent = new Intent(context, AddEditActivity.class);
                intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                intent.putExtra("editMode", true);
                intent.putExtra("informationId", information.getId());
                context.startActivity(intent);
                break;
        }
        return true;
    }
}

