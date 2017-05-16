package com.example.nick.myemergency;

import java.util.ArrayList;

import android.content.Context;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;
import android.widget.TabHost;

public class InformationFragment extends Fragment {

    private ListView informationView;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        // inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_information,
                container, false);

        // get references to widgets
        informationView = (ListView) view.findViewById (R.id.informationView);

        // refresh the task list view
        refreshTaskList();

        // return the view
        return view;
    }

    public void refreshTaskList() {
        // get task list for current tab from database
        Context context = getActivity().getApplicationContext();
        MyEmergencyDB db = new MyEmergencyDB(context);
        ArrayList<Information> informations = db.getInformations();

        // create adapter and set it in the ListView widget
        InformationAdapter adapter = new InformationAdapter(context, informations);
        informationView.setAdapter(adapter);
    }

    @Override
    public void onResume() {
        super.onResume();
        refreshTaskList();
    }
}
