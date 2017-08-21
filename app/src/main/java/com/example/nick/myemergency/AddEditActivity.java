package com.example.nick.myemergency;


import android.app.Activity;
import android.app.DatePickerDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.database.Cursor;
import android.net.Uri;
import android.os.Bundle;
import android.preference.Preference;
import android.preference.PreferenceManager;
import android.provider.ContactsContract;
import android.support.annotation.IdRes;
import android.telephony.TelephonyManager;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnKeyListener;
import android.view.WindowManager;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.Switch;
import android.widget.TextView;
import android.widget.Toast;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Locale;
import java.util.regex.Matcher;
import java.util.regex.Pattern;


public class AddEditActivity extends Activity
        implements OnKeyListener, RadioGroup.OnCheckedChangeListener {

    private TextView textViewInfo;
    private EditText nameEditText;
    private EditText surnameEditText;
    private EditText CFEditText;
    private EditText anniEditText;
    private EditText telephoneEditText;
    private EditText contact1EditText;
    private EditText contact2EditText;
    private Button contact1Button;
    private Button contact2Button;
    private RadioGroup radioSendMessages;

    private MyEmergencyDB db;
    private boolean editMode;
    private boolean firstTime = false;
    private Information information;

    // define messages constants
    private final int MESSAGES_NONE = 0;
    private final int MESSAGES_NORMAL = 1;
    private final int MESSAGES_WHATSAPP = 2;

    // set up preferences
    private SharedPreferences prefs;
    private Boolean rememberPhoneNumber = true;
    private int messages_type = MESSAGES_NONE;
    final Calendar myCalendar = Calendar.getInstance();

    public final int PICK_CONTACT1 = 2015;
    public final int PICK_CONTACT2 = 3015;


    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_edit);
        this.getWindow().setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_STATE_ALWAYS_HIDDEN);

        // get default SharedPreferences object
        prefs = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());

        // get references to widgets
        textViewInfo = (TextView) findViewById(R.id.textViewInfo);
        nameEditText = (EditText) findViewById(R.id.nameEditText);
        surnameEditText = (EditText) findViewById(R.id.surnameEditText);
        CFEditText = (EditText) findViewById(R.id.CFEditText);
        anniEditText = (EditText) findViewById(R.id.anniEditText);
        telephoneEditText = (EditText) findViewById(R.id.telephoneEditText);
        radioSendMessages = (RadioGroup) findViewById(R.id.radioSendMessages);
        contact1EditText = (EditText) findViewById(R.id.contact1EditText);
        contact1Button = (Button) findViewById(R.id.contact1Button);
        contact1Button.setOnClickListener( new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent i = new Intent(Intent.ACTION_PICK, ContactsContract.CommonDataKinds.Phone.CONTENT_URI);
                startActivityForResult(i, PICK_CONTACT1);
            }
        });
        contact2EditText = (EditText) findViewById(R.id.contact2EditText);
        contact2Button = (Button) findViewById(R.id.contact2Button);
        contact2Button.setOnClickListener( new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent i = new Intent(Intent.ACTION_PICK, ContactsContract.CommonDataKinds.Phone.CONTENT_URI);
                startActivityForResult(i, PICK_CONTACT2);
            }
        });


        final DatePickerDialog.OnDateSetListener date = new DatePickerDialog.OnDateSetListener() {

            @Override
            public void onDateSet(DatePicker view, int year, int monthOfYear,
                                  int dayOfMonth) {
                // TODO Auto-generated method stub
                myCalendar.set(Calendar.YEAR, year);
                myCalendar.set(Calendar.MONTH, monthOfYear);
                myCalendar.set(Calendar.DAY_OF_MONTH, dayOfMonth);
                updateLabel();
            }

        };

        anniEditText.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                // TODO Auto-generated method stub
                new DatePickerDialog(AddEditActivity.this, date, myCalendar
                        .get(Calendar.YEAR), myCalendar.get(Calendar.MONTH),
                        myCalendar.get(Calendar.DAY_OF_MONTH)).show();
            }
        });

        // set listeners
        radioSendMessages.setOnCheckedChangeListener(this);
        nameEditText.setOnKeyListener(this);
        surnameEditText.setOnKeyListener(this);
        CFEditText.setOnKeyListener(this);
        anniEditText.setOnKeyListener(this);
        telephoneEditText.setOnKeyListener(this);

        nameEditText.addTextChangedListener(new TextWatcher()  {

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
            }

            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {
            }

            @Override
            public void afterTextChanged(Editable s)  {
                if (nameEditText.getText().toString().length() <= 0) {
                    nameEditText.setError("Questo campo non può essere vuoto");
                } else {
                    nameEditText.setError(null);
                }
            }
        });

        surnameEditText.addTextChangedListener(new TextWatcher()  {

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
            }

            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {
            }

            @Override
            public void afterTextChanged(Editable s)  {
                if (surnameEditText.getText().toString().length() <= 0) {
                    surnameEditText.setError("Questo campo non può essere vuoto");
                } else {
                   surnameEditText.setError(null);
                }
            }
        });

        CFEditText.addTextChangedListener(new TextWatcher()  {

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
            }

            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {
            }

            @Override
            public void afterTextChanged(Editable s)  {
                String pattern = "^[A-Z]{6}[0-9]{2}[ABCDEHLMPRST]{1}[0-9]{2}([a-zA-Z]{1}[0-9]{3})[a-zA-Z]{1}$";
                Pattern regEx = Pattern.compile(pattern);
                Matcher m = regEx.matcher(CFEditText.getText().toString());
                if (CFEditText.getText().toString().length() <= 0) {
                    CFEditText.setError("Questo campo non può essere vuoto");
                } else if (!m.matches()) {
                    CFEditText.setError("CF non rispettato");
                } else {
                    CFEditText.setError(null);
                }
            }
        });

        anniEditText.addTextChangedListener(new TextWatcher()  {

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
            }

            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {
            }

            @Override
            public void afterTextChanged(Editable s)  {
                String pattern = "((((0[1-9]|1[0-9]|2[0-8])(\\/)(0[1-9]|1[0-2]))|((2[9]|3[0])(\\/)(0[469]|11))|((3[1])(\\/)(0[13578]|1[02])))(\\/)(19([0-9][0-9])|20(0[0-9]|1[0-5])))|((29)(\\/)(02)(\\/)(19(0[048]|1[26]|2[048]|3[26]|4[048]|5[26]|6[048]|7[26]|8[048]|9[26])|20(0[048]|1[26])))";
                Pattern regEx = Pattern.compile(pattern);
                Matcher m = regEx.matcher(anniEditText.getText().toString());
                if (anniEditText.getText().toString().length() <= 0) {
                    anniEditText.setError("Questo campo non può essere vuoto");
                } else if (!m.matches()) {
                    anniEditText.setError("Formato da rispettare gg/mm/aaaa");
                } else {
                    anniEditText.setError(null);
                }
            }
        });

        telephoneEditText.addTextChangedListener(new TextWatcher()  {

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
            }

            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {
            }

            @Override
            public void afterTextChanged(Editable s)  {
                if (telephoneEditText.getText().toString().length() <= 0) {
                    telephoneEditText.setError("Questo campo non può essere vuoto");
                } else if (telephoneEditText.getText().toString().length() >10) {
                    telephoneEditText.setError("formato numero telefonico non rispettato");
                } else {
                    telephoneEditText.setError(null);
                }
            }
        });

        // get the database object
        db = new MyEmergencyDB(this);

        // get edit mode from intent
        Intent intent = getIntent();
        editMode = intent.getBooleanExtra("editMode", false);
        firstTime = intent.getBooleanExtra("first", false);
        if (!editMode) {
            if (firstTime) {
                textViewInfo.setText("Inserisci i tuoi dati per poterli avere a disposizione nel momento del bisogno");
            } else {
                textViewInfo.setText("Inserisci i dati di qualcuno che potrebbe avere bisogno");
            }
        } else {
            textViewInfo.setText("Aggiornamento dei dati");
        }

        if(!getPackageManager().hasSystemFeature(PackageManager.FEATURE_TELEPHONY)) {
            ((RadioButton)radioSendMessages.getChildAt(1)).setEnabled(false);
        }

        rememberPhoneNumber = prefs.getBoolean("pref_remember_phone_number", true);
        messages_type = Integer.parseInt(prefs.getString("pref_messages", "0"));
        ((RadioButton)radioSendMessages.getChildAt(messages_type)).setChecked(true);
        if (!firstTime) {
            for(int i = 0; i < radioSendMessages.getChildCount(); i++){
                radioSendMessages.getChildAt(i).setEnabled(false);
            }
            if (!rememberPhoneNumber) {
                telephoneEditText.setClickable(true);
                telephoneEditText.setCursorVisible(true);
                telephoneEditText.setFocusable(true);
                telephoneEditText.setFocusableInTouchMode(true);
            } else {
                telephoneEditText.setText(db.getInformation(1).getTelephone());
            }

        } else {
            telephoneEditText.setClickable(true);
            telephoneEditText.setCursorVisible(true);
            telephoneEditText.setFocusable(true);
            telephoneEditText.setFocusableInTouchMode(true);
        }

        if (messages_type == MESSAGES_NONE) {
            contact1EditText.setText(null);
            contact2EditText.setText(null);
            contact1EditText.setVisibility(View.INVISIBLE);
            contact1Button.setVisibility(View.INVISIBLE);
            contact2EditText.setVisibility(View.INVISIBLE);
            contact2Button.setVisibility(View.INVISIBLE);
        } else if (messages_type == MESSAGES_WHATSAPP) {
            contact1EditText.setVisibility(View.VISIBLE);
            contact1Button.setVisibility(View.VISIBLE);
            contact2EditText.setText(null);
            contact2EditText.setVisibility(View.INVISIBLE);
            contact2Button.setVisibility(View.INVISIBLE);
        } else {
            contact1EditText.setVisibility(View.VISIBLE);
            contact1Button.setVisibility(View.VISIBLE);
            contact2EditText.setVisibility(View.VISIBLE);
            contact2Button.setVisibility(View.VISIBLE);
            contact1EditText.setText(null);
            contact2EditText.setText(null);
        }

        // if editing
        if (editMode) {
            // get information
            long informationId = intent.getLongExtra("informationId", -1);
            information = db.getInformation(informationId);

            // update UI with task
            nameEditText.setText(information.getName());
            surnameEditText.setText(information.getSurname());
            CFEditText.setText(information.getCodiceFiscale());
            anniEditText.setText(information.getDate_of_birth());
            telephoneEditText.setClickable(true);
            telephoneEditText.setCursorVisible(true);
            telephoneEditText.setFocusable(true);
            telephoneEditText.setFocusableInTouchMode(true);
            telephoneEditText.setText(information.getTelephone());
            contact1EditText.setText(information.getContact1());
            contact2EditText.setText(information.getContact2());
        }
    }

    @Override
    public void onPause() {

        super.onPause();
    }

    @Override
    public void onResume() {
        super.onResume();

        // get preferences
        rememberPhoneNumber = prefs.getBoolean("pref_remember_phone_number", true);
        messages_type = Integer.parseInt(prefs.getString("pref_message", "0"));

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_add_edit, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()){
            case R.id.menuSave:
                InputMethodManager inputManager = (InputMethodManager)
                        getSystemService(Context.INPUT_METHOD_SERVICE);

                inputManager.hideSoftInputFromWindow(getCurrentFocus().getWindowToken(),
                        InputMethodManager.HIDE_NOT_ALWAYS);
                String name = nameEditText.getText().toString();
                String surname = surnameEditText.getText().toString();
                String CF = CFEditText.getText().toString();
                String date_of_birth = anniEditText.getText().toString();
                String telephone = telephoneEditText.getText().toString();

                // if no informations, exit method

                if (name.equals("")) {
                    nameEditText.setError("Questo campo non può essere vuoto");
                }
                if (surname.equals("")) {
                    surnameEditText.setError("Questo campo non può essere vuoto");
                }
                if (CF.equals("")) {
                    CFEditText.setError("Questo campo non può essere vuoto");
                }
                if (date_of_birth.equals("")) {
                    anniEditText.setError("Questo campo non può essere vuoto");
                }
                if (telephone.equals("")) {
                    telephoneEditText.setError("Questo campo non può essere vuoto");
                }
                if ((nameEditText.getError() == null && nameEditText.getText().length() != 0) &&
                        (surnameEditText.getError() == null && surnameEditText.getText().length() != 0) &&
                        (CFEditText.getError() == null && CFEditText.getText().length() != 0) &&
                        (anniEditText.getError() == null && anniEditText.getText().length() != 0) &&
                        (telephoneEditText.getError() == null && telephoneEditText.getText().length() != 0)) {
                        saveToDB();
                        if (!firstTime) {
                            this.finish();
                        } else {
                            Intent intent = new Intent(this, FistLaunch.class);
                            startActivity(intent);
                            finish();
                        }
                }
                break;
            case R.id.menuCancel:
                    if(!firstTime) {
                        this.finish();
                    } else {
                        Intent intent = new Intent(getApplicationContext(), SettingsActivity.class);
                        intent.putExtra("first", true);
                        startActivity(intent);
                        finish();
                    }

                break;
        }
        return super.onOptionsItemSelected(item);
    }

    private void saveToDB() {
        // get data from widgets
        String name = nameEditText.getText().toString();
        String surname = surnameEditText.getText().toString();
        String CF = CFEditText.getText().toString();
        String date_of_birth = anniEditText.getText().toString();
        String telephone = telephoneEditText.getText().toString();
        String contact1 = contact1EditText.getText().toString();
        String contact2 = contact2EditText.getText().toString();

        // if add mode, create new information
        if (!editMode) {
            information = new Information();
        }

        // put data in information
        information.setName(name);
        information.setSurname(surname);
        information.setCodiceFiscale(CF);
        information.setDate_of_birth(date_of_birth);
        information.setTelephone(telephone);
        information.setContact1(contact1);
        information.setContact2(contact2);

        // update or insert task
        if (editMode) {
            db.updateInformation(information);
        }
        else {
            db.insertInformation(information);
        }
    }

    @Override
    public boolean onKey(View view, int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_DPAD_CENTER) {
            // hide the soft Keyboard
            InputMethodManager imm = (InputMethodManager)
                    getSystemService(Context.INPUT_METHOD_SERVICE);
            imm.hideSoftInputFromWindow(view.getWindowToken(), 0);
            return true;
        }
        return false;
    }

    private void updateLabel() {
        String myFormat = "dd/MM/yyyy"; //In which you need put here
        SimpleDateFormat sdf = new SimpleDateFormat(myFormat, Locale.ITALIAN);

        anniEditText.setText(sdf.format(myCalendar.getTime()));
    }


    @Override
    public void onBackPressed() {
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == PICK_CONTACT1 && resultCode == RESULT_OK) {
            Uri contactUri = data.getData();
            Cursor cursor = getContentResolver().query(contactUri, null, null, null, null);
            cursor.moveToFirst();
            int column = cursor.getColumnIndex(ContactsContract.CommonDataKinds.Phone.NUMBER);
            String phoneNo = cursor.getString(column);
            Log.d("pluto",phoneNo.substring(0,3));
            if (phoneNo.substring(0,3).equals("+39")) {

                phoneNo = phoneNo.substring(3);
            }
            contact1EditText.setText(phoneNo);
        } else if (requestCode == PICK_CONTACT2 && resultCode == RESULT_OK) {
            Uri contactUri = data.getData();
            Cursor cursor = getContentResolver().query(contactUri, null, null, null, null);
            cursor.moveToFirst();
            int column = cursor.getColumnIndex(ContactsContract.CommonDataKinds.Phone.NUMBER);
            String phoneNo = cursor.getString(column);
            if (phoneNo.substring(0,3).equals("+39")) {
                phoneNo = phoneNo.substring(3);
            }
            contact2EditText.setText(phoneNo);
        }
    }

    @Override
    public void onCheckedChanged(RadioGroup group, @IdRes int checkedId) {
        switch (checkedId) {
            case R.id.radioNone:
                contact1EditText.setText(null);
                contact2EditText.setText(null);
                contact1EditText.setVisibility(View.INVISIBLE);
                contact1Button.setVisibility(View.INVISIBLE);
                contact2EditText.setVisibility(View.INVISIBLE);
                contact2Button.setVisibility(View.INVISIBLE);
                messages_type = MESSAGES_NONE;
                break;
            case R.id.radioMessage:
                contact1EditText.setVisibility(View.VISIBLE);
                contact2EditText.setVisibility(View.VISIBLE);
                contact1Button.setVisibility(View.VISIBLE);
                contact2Button.setVisibility(View.VISIBLE);
                messages_type = MESSAGES_NORMAL;
                break;
            case R.id.radioWhatsapp:
                contact1EditText.setVisibility(View.VISIBLE);
                contact1Button.setVisibility(View.VISIBLE);
                contact2EditText.setText(null);
                contact2EditText.setVisibility(View.INVISIBLE);
                contact2Button.setVisibility(View.INVISIBLE);
                messages_type = MESSAGES_WHATSAPP;
                break;
            default:
                break;
        }
        SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());
        SharedPreferences.Editor editor = preferences.edit();
        editor.putString("pref_messages", Integer.toString(messages_type));
        editor.commit();
    }
}
