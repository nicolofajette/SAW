package com.example.nick.myemergency;

import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.preference.ListPreference;
import android.preference.Preference;
import android.preference.PreferenceFragment;
import android.preference.PreferenceManager;
import android.app.Fragment;
import android.preference.PreferenceScreen;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;


public class SettingsFragment extends PreferenceFragment
        implements SharedPreferences.OnSharedPreferenceChangeListener {

    private SharedPreferences prefs;
    private Boolean firstTime;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        addPreferencesFromResource(R.xml.preferences);
        prefs = PreferenceManager.getDefaultSharedPreferences(getActivity());
        firstTime = ((SettingsActivity) getActivity()).getFirstTime();
        if (!firstTime) {
            PreferenceScreen screen = getPreferenceScreen();
            Preference pref = getPreferenceManager().findPreference("pref_messages");
            screen.removePreference(pref);
        }
        if (!getActivity().getPackageManager().hasSystemFeature(PackageManager.FEATURE_TELEPHONY)) {
            ListPreference messages_type = (ListPreference) findPreference("pref_messages");
            messages_type.setEntries(new String[]{"Nessuno","Whatsapp"});
            messages_type.setEntryValues(new String[]{"0", "2"});
        }
    }

    @Override
    public void onResume() {
        super.onResume();
        prefs.registerOnSharedPreferenceChangeListener(this);
    }

    @Override
    public void onPause() {
        prefs.unregisterOnSharedPreferenceChangeListener(this);
        super.onPause();
    }

    @Override
    public void onSharedPreferenceChanged(SharedPreferences prefs,
                                          String key) {
    }
}
