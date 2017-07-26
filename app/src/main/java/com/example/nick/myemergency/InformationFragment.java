package com.example.nick.myemergency;

import java.util.ArrayList;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;

public class InformationFragment extends Fragment {

    MyEmergencyDB db;
    private ListView informationView;

    public InformationFragment() {
        setHasOptionsMenu(true);
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        // inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_information,
                container, false);

        // get references to widgets
        informationView = (ListView) view.findViewById (R.id.View);
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
        inflater.inflate(R.menu.activity_task_list,menu);
        super.onCreateOptionsMenu(menu, inflater);
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

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()){
            case R.id.menuAddTask:
                Intent intent = new Intent(getContext(), AddEditActivity.class);
                intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                intent.putExtra("editMode", false);
                intent.putExtra("first", false);
                startActivity(intent);
                break;
            case R.id.menuDelete:
                // Hide all tasks marked as cancel
                ArrayList<Information> informations = db.getInformations();
                for (Information information : informations){
                    if (information.getCancelDateMillis() > 0){
                        information.setHidden(Information.TRUE);
                        //db.updateInformation(information);
                        db.deleteInformation(information);
                    }
                }
                // Refresh list
                refreshTaskList();
                break;
            case R.id.menu_settings:
                startActivity(new Intent(getActivity(), SettingsActivity.class));
                break;
        }
        return super.onOptionsItemSelected(item);
    }
}
