package com.example.nick.myemergency;

import android.support.v4.app.Fragment;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;



public class TutorialFragment2 extends Fragment {

    private Button continueButton;
    private Boolean tutorial = false;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        tutorial = getArguments().getBoolean("tutorial");
        View view = inflater.inflate(R.layout.tutorial_fragment2, container, false);

        continueButton = (Button) view.findViewById(R.id.buttonContinue);
        if (tutorial) {
            continueButton.setVisibility(View.GONE);
        }


        continueButton.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View arg0) {
                Intent intent = new Intent(getActivity(), SettingsActivity.class);
                intent.putExtra("first", true);
                startActivity(intent);
                getActivity().finish();
            }

        });

        return view;

    }


}
