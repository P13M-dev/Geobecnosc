package com.example.jestem;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.SharedPreferences;
import android.os.Build;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;

import java.util.Arrays;

public class HomeActivity extends AppCompatActivity {

    BroadcastReceiver verifyReceiver =
        new BroadcastReceiver() {

            @Override
            public void onReceive(Context context, Intent intent) {
                runOnUiThread(() -> updateVerification());
            }
        };

    LinearLayout logoutPopup;

    @RequiresApi(api = Build.VERSION_CODES.TIRAMISU)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home);

        registerReceiver(
                verifyReceiver,
                new IntentFilter("VERIFY_UPDATE"),
                RECEIVER_NOT_EXPORTED
        );

        SharedPreferences prefs = getSharedPreferences("app", MODE_PRIVATE);

        updateVerification();

        logoutPopup = findViewById(R.id.logoutPopup);

        findViewById(R.id.logoutButton).setOnClickListener((view) -> logoutPopup.setVisibility(View.VISIBLE));

        findViewById(R.id.cancelButton) .setOnClickListener((view) -> logoutPopup.setVisibility(View.GONE));
        findViewById(R.id.confirmButton).setOnClickListener((view) -> {
            logoutPopup.setVisibility(View.GONE);

            RequestsManager.post(
                    prefs.getString("domain", ""),
                    new Header[]{new Header("Authorization", "wylogujUczen")},
                    new String[][]{
                            {"token", prefs.getString("token", "")}
                    }
            );

            SharedPreferences.Editor editor = prefs.edit();

            editor.putString("token", "");
            editor.putBoolean("verified", false);

            editor.apply();

            startActivity(new Intent(this, MainActivity.class));
            finish();
        });
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();

        unregisterReceiver(verifyReceiver);
    }

    @Override
    protected void onNewIntent(Intent intent) {
        super.onNewIntent(intent);

        updateVerification();
    }

    @Override
    protected void onResume() {
        super.onResume();

        updateVerification();
    }

    private void updateVerification() {

        SharedPreferences prefs = getSharedPreferences("app", MODE_PRIVATE);

        TextView verificationText = findViewById(R.id.verificationText);
        verificationText.setVisibility(
                prefs.getBoolean("verified", false)
                        ? View.GONE
                        : View.VISIBLE
        );

        LinearLayout hello = findViewById(R.id.hello);
        hello.setVisibility(
                prefs.getBoolean("verified", false)
                        ? View.VISIBLE
                        : View.GONE
        );

        Button logoutButton = findViewById(R.id.logoutButton);
        logoutButton.setVisibility(
                prefs.getBoolean("verified", false)
                        ? View.VISIBLE
                        : View.GONE
        );

        String data = RequestsManager.post(
                prefs.getString("domain", ""),
                new Header[]{new Header("Authorization", "wybierzImieNazwiskoU")},
                new String[][]{
                        {"token", prefs.getString("token", "")}
                }
        );

        System.out.println("data: " + data);
        System.out.println(prefs.getString("token", ""));
        String[] dataSplit = data.split("λ");
        System.out.println(Arrays.toString(dataSplit));

        if (dataSplit.length == 3) {
            TextView greetings = findViewById(R.id.witay);
            greetings.setText(String.format("Witaj, %s %s", dataSplit[0], dataSplit[1]));

            TextView className = findViewById(R.id.witaj);
            className.setText(dataSplit[2]);
        }
    }
}