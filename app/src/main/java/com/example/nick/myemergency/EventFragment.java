package com.example.nick.myemergency;


import android.content.Intent;
import android.support.v4.app.Fragment;
import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;
import android.widget.Toast;

import java.util.ArrayList;

public class EventFragment extends Fragment {

    MyEmergencyDB db;
    private ListView eventView;

    public EventFragment() {
        setHasOptionsMenu(true);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        // inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_information,
                container, false);

        // get references to widgets
        eventView = (ListView) view.findViewById (R.id.View);
        // get database
        db = new MyEmergencyDB(getContext());

        // refresh the task list view
        refreshTaskList();

        // return the view
        return view;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setHasOptionsMenu(true);
    }

    @Override
    public void onCreateOptionsMenu(Menu menu, MenuInflater inflater){
        menu.clear();
        inflater.inflate(R.menu.event_fragment,menu);
        super.onCreateOptionsMenu(menu, inflater);
    }

    public void refreshTaskList() {
        // get task list for current tab from database
        Context context = getActivity().getApplicationContext();
        MyEmergencyDB db = new MyEmergencyDB(context);
        ArrayList<Evento> events = db.getEvents();

        // create adapter and set it in the ListView widget
        EventAdapter adapter = new EventAdapter(context, events);
        eventView.setAdapter(adapter);
    }


    @Override
    public void onResume() {
        super.onResume();
        refreshTaskList();
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()){
            case R.id.menuDelete:
                // Cancel all events
                db.deleteEvents();
                // Refresh list
                refreshTaskList();

                break;
        }
        return super.onOptionsItemSelected(item);
    }
}

