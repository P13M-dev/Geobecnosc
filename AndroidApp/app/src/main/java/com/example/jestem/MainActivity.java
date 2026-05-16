package com.example.jestem;

import android.Manifest;
import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Build;
import android.os.Bundle;
import android.provider.Settings;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;

import androidx.activity.EdgeToEdge;
import androidx.annotation.RequiresPermission;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import java.util.Calendar;
import java.util.Objects;

public class MainActivity extends AppCompatActivity {

    private EditText emailField;
    private EditText passwordField;
    private EditText domainField;

    private CheckBox domainCheckbox;

//    private Button loginButton;

    @RequiresPermission(Manifest.permission.SCHEDULE_EXACT_ALARM)
    @Override
    protected void onCreate(Bundle savedInstanceState) {

        AlarmManager alarmManager = (AlarmManager) getSystemService(Context.ALARM_SERVICE);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.S) {
            if (!alarmManager.canScheduleExactAlarms()) {
                Intent requestPermissions = new Intent(Settings.ACTION_REQUEST_SCHEDULE_EXACT_ALARM);

                startActivity(requestPermissions);
            }
        }

        SharedPreferences prefs = getSharedPreferences("app", MODE_PRIVATE);

        if (!prefs.getString("token", "").isEmpty()) {
            startActivity(new Intent(this, HomeActivity.class));
            finish();
        }

        super.onCreate(savedInstanceState);
        getWindow().setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_ADJUST_RESIZE);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.R) {
            getWindow().setDecorFitsSystemWindows(true);
        }
        setContentView(R.layout.activity_main);

        domainCheckbox = findViewById(R.id.domainCheckbox);
        passwordField = findViewById(R.id.passwordInput);
        domainField = findViewById(R.id.domainInput);
        emailField = findViewById(R.id.emailInput);

        emailField.setOnFocusChangeListener(
                (view, focused) -> view.setBackgroundResource(R.drawable.input_background)
        );
        passwordField.setOnFocusChangeListener(
                (view, focused) -> view.setBackgroundResource(R.drawable.input_background)
        );
        domainField.setOnFocusChangeListener(
                (view, focused) -> view.setBackgroundResource(R.drawable.input_background)
        );

        domainCheckbox.setOnCheckedChangeListener((view, checked) -> {
            if (checked) domainField.setVisibility(View.VISIBLE);
            else         domainField.setVisibility(View.GONE);
        });

        findViewById(R.id.loginButton).setOnClickListener((view) -> {
            String password = passwordField.getText().toString();
            String email = emailField.getText().toString();
            String domain = "";
            String[][] payload = {
                    {"email", email},
                    {"haslo", password}
            };

            boolean correctData = true;

            if (email.isEmpty()) {
                emailField.setBackgroundResource(R.drawable.input_error_background);
                correctData = false;
            } else if (email.indexOf('@') == -1) {
                emailField.setBackgroundResource(R.drawable.input_error_background);
                correctData = false;
            }

            if (password.isEmpty()) {
                passwordField.setBackgroundResource(R.drawable.input_error_background);
                correctData = false;
            }

            if (domainCheckbox.isChecked() && domainField.getText().toString().isEmpty()) {
                domainField.setBackgroundResource(R.drawable.input_error_background);
                correctData = false;
            } else if (domainCheckbox.isChecked()) domain = domainField.getText().toString();
            else domain = "https://casino-lunacy-riveter.ngrok-free.dev/api";

            if (correctData) {
                String data = RequestsManager.post(
                        domain,
                        new Header[]{new Header("Authorization", "zalogujUczen")},
                        payload
                );

                System.out.println("AAAAAAAAAAAAAAAAAAAAA" + data);


                if (Objects.equals(data, "incorrect") || data.isEmpty()) {
                    emailField.setBackgroundResource(R.drawable.input_error_background);
                    passwordField.setBackgroundResource(R.drawable.input_error_background);
                    return;
                }

                SharedPreferences.Editor editor = prefs.edit();
                editor.putString("token", data);
                editor.putString("email", email);
                editor.putString("password", password);
                editor.putString("domain", domain);
                editor.putBoolean("verified", false);
                editor.apply();

                System.out.println("USTAWIONY TIMER");

                // 24h
//                long trigger = System.currentTimeMillis() + 24 * 60 * 60 * 1000;

                long trigger = System.currentTimeMillis() + 5000;

                if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.S) if (alarmManager.canScheduleExactAlarms())
                    alarmManager.setExact(
                            AlarmManager.RTC_WAKEUP,
                            trigger,
                            PendingIntent.getBroadcast(
                                    this, 0,
                                    new Intent(this, VerifyToken.class),
                                    PendingIntent.FLAG_IMMUTABLE
                            )
                    );

                startActivity(new Intent(this, HomeActivity.class));
                finish();
            }
        });
    }
}