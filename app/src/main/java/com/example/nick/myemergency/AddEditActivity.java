package com.example.nick.myemergency;


import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnKeyListener;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;

public class AddEditActivity extends Activity
        implements OnKeyListener {

    private EditText nameEditText;
    private EditText surnameEditText;
    private EditText CFEditText;
    private EditText anniEditText;
    private EditText telephoneEditText;
    private EditText contact1EditText;
    private EditText contact2EditText;

    private MyEmergencyDB db;
    private boolean editMode;
    private String currentInformationName = "";
    private Information information;

    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_edit);

        // get references to widgets
        nameEditText = (EditText) findViewById(R.id.nameEditText);
        surnameEditText = (EditText) findViewById(R.id.surnameEditText);
        CFEditText = (EditText) findViewById(R.id.CFEditText);
        anniEditText = (EditText) findViewById(R.id.anniEditText);
        telephoneEditText = (EditText) findViewById(R.id.telephoneEditText);
        contact1EditText = (EditText) findViewById(R.id.contact1EditText);
        contact2EditText = (EditText) findViewById(R.id.contact2EditText);

        // set listeners
        nameEditText.setOnKeyListener(this);
        surnameEditText.setOnKeyListener(this);
        CFEditText.setOnKeyListener(this);
        anniEditText.setOnKeyListener(this);
        telephoneEditText.setOnKeyListener(this);
        contact1EditText.setOnKeyListener(this);
        contact2EditText.setOnKeyListener(this);

        // get the database object
        db = new MyEmergencyDB(this);

        // get edit mode from intent
        Intent intent = getIntent();
        editMode = intent.getBooleanExtra("editMode", false);

        // if editing
        if (editMode) {
            // get information
            long informationId = intent.getLongExtra("informationId", -1);
            information = db.getInformation(informationId);

            // update UI with task
            nameEditText.setText(information.getName());
            surnameEditText.setText(information.getSurname());
            CFEditText.setText(information.getCF());
            anniEditText.setText(information.getAnni());
            telephoneEditText.setText(information.getTelephone());
            contact1EditText.setText(information.getContact1());
            contact2EditText.setText(information.getContact2());
        }
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
                saveToDB();
                this.finish();
                break;
            case R.id.menuCancel:
                this.finish();
                break;
        }
        return super.onOptionsItemSelected(item);
    }

    private void saveToDB() {
        // get data from widgets
        String name = nameEditText.getText().toString();
        String surname = surnameEditText.getText().toString();
        String CF = CFEditText.getText().toString();
        String anni = anniEditText.getText().toString();
        String telephone = telephoneEditText.getText().toString();
        String contact1 = contact1EditText.getText().toString();
        String contact2 = contact2EditText.getText().toString();

        // if no information name, exit method
        if (name == null || name.equals("")) {
            return;
        }

        // if add mode, create new information
        if (!editMode) {
            information = new Information();
        }

        // put data in information
        information.setName(name);
        information.setSurname(surname);
        information.setCF(CF);
        information.setAnni(anni);
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
        else if (keyCode == KeyEvent.KEYCODE_BACK) {
            saveToDB();
            return false;
        }
        return false;
    }
}
