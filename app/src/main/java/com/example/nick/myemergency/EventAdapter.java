package com.example.nick.myemergency;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;

import java.util.ArrayList;

public class EventAdapter extends BaseAdapter {

    private Context context;
    private ArrayList<Evento> events;

    public EventAdapter(Context context, ArrayList<Evento> events){
        this.context = context;
        this.events = events;
    }

    @Override
    public int getCount() {
        return events.size();
    }

    @Override
    public Object getItem(int position) {
        return events.get(position);
    }

    @Override    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        EventLayout eventLayout = null;
        Evento event = events.get(position);

        if (convertView == null) {
            eventLayout = new EventLayout(context, event);
        }
        else {
            eventLayout = (EventLayout) convertView;
            eventLayout.setEvent(event);
        }
        return eventLayout;
    }
}
