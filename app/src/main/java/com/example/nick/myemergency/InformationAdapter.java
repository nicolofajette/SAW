package com.example.nick.myemergency;

import java.util.ArrayList;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;

public class InformationAdapter extends BaseAdapter {

    private Context context;
    private ArrayList<Information> informations;

    public InformationAdapter(Context context, ArrayList<Information> informations){
        this.context = context;
        this.informations = informations;
    }

    @Override
    public int getCount() {
        return informations.size();
    }

    @Override
    public Object getItem(int position) {
        return informations.get(position);
    }

    @Override    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        InformationLayout informationLayout = null;
        Information information = informations.get(position);

        if (convertView == null) {
            informationLayout = new InformationLayout(context, information);
        }
        else {
            informationLayout = (InformationLayout) convertView;
            informationLayout.setInformation(information);
        }
        return informationLayout;
    }
}
