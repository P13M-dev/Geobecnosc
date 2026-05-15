package com.example.jestem;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

public class HomeActivity extends AppCompatActivity {

    LinearLayout logoutPopup;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home);

        logoutPopup = findViewById(R.id.logoutPopup);

        findViewById(R.id.logoutButton).setOnClickListener((view) -> logoutPopup.setVisibility(View.VISIBLE));

        findViewById(R.id.cancelButton) .setOnClickListener((view) -> logoutPopup.setVisibility(View.GONE));
        findViewById(R.id.confirmButton).setOnClickListener((view) -> {
            logoutPopup.setVisibility(View.GONE);

            SharedPreferences prefs = getSharedPreferences("app", MODE_PRIVATE);
            SharedPreferences.Editor editor = prefs.edit();

            editor.putString("token", "");
            editor.putBoolean("verified", false);

            editor.apply();

            startActivity(new Intent(this, MainActivity.class));
            finish();
        });
    }
}