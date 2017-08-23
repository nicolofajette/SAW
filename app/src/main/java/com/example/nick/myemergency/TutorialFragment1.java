package com.example.nick.myemergency;

import android.support.v4.app.Fragment;
import android.app.FragmentTransaction;
import android.content.Intent;
import android.graphics.Paint;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;



public class TutorialFragment1 extends Fragment {

    private Button skipButton;
    private Button continueButton;
    private ImageView image;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.tutorial_fragment1, container, false);

        skipButton = (Button) view.findViewById(R.id.buttonSkip);
        skipButton.setPaintFlags(skipButton.getPaintFlags() | Paint.UNDERLINE_TEXT_FLAG);
        continueButton = (Button) view.findViewById(R.id.buttonContinue);
        image = (ImageView) view.findViewById(R.id.imageView);
        image.setImageResource(R.drawable.ic_launcher);

        skipButton.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View arg0) {
                Intent intent = new Intent(getActivity(),  SettingsActivity.class);
                intent.putExtra("first", true);
                startActivity(intent);
                getActivity().finish();
            }

        });
        continueButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View arg0) {
                // Create new fragment and transaction
                Bundle bundle = new Bundle();
                bundle.putBoolean("tutorial", false);
                TutorialFragment2 newFragment = new TutorialFragment2();
                newFragment.setArguments(bundle);
                getActivity().getSupportFragmentManager().beginTransaction()
                        .replace(R.id.fragment_container, newFragment).addToBackStack(null);
                getActivity().getSupportFragmentManager().beginTransaction()
                        .replace(R.id.fragment_container, newFragment).commit();

            }

        });
        setRetainInstance(true);
        return view;

    }


}
