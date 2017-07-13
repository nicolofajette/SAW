package com.example.nick.myemergency;


import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.CheckBox;
import android.widget.RelativeLayout;
import android.widget.TextView;

public class EventLayout extends RelativeLayout {

    private TextView typeTextView;
    private TextView nameTextView;
    private TextView timeTextView;

    private Evento event;
    private MyEmergencyDB db;
    private Context context;

    public EventLayout(Context context) {   // used by Android tools
        super(context);
    }

    public EventLayout(Context context, Evento e) {
        super(context);

        // set context and get db object
        this.context = context;
        db = new MyEmergencyDB(context);

        // inflate the layout
        LayoutInflater inflater = (LayoutInflater)
                context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        inflater.inflate(R.layout.listview_event, this, true);

        // get references to widgets
        typeTextView = (TextView) findViewById(R.id.typeTextView);
        nameTextView = (TextView) findViewById(R.id.nameTextView);
        timeTextView = (TextView) findViewById(R.id.timeTextView);

        // set task data on widgets
        setEvent(e);
    }

    public void setEvent(Evento e) {
        event = e;
        typeTextView.setText(event.getType());
        nameTextView.setText(event.getName());
        timeTextView.setText(event.getTime());
    }
}
