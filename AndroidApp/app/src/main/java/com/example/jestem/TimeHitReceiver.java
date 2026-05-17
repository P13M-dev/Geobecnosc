package com.example.jestem;

import static android.content.Context.MODE_PRIVATE;

import android.Manifest;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;

import androidx.core.app.ActivityCompat;

import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;

import java.util.Arrays;

public class TimeHitReceiver extends BroadcastReceiver {
    public static final String ACTION_TIME_HIT = "com.example.jestem.ACTION_TIME_HIT";

    @Override
    public void onReceive(Context context, Intent intent) {

        System.out.println("SENDING ATTENDANCE");

        FusedLocationProviderClient fusedLocationClient =
                LocationServices.getFusedLocationProviderClient(context);

        if (
                ActivityCompat.checkSelfPermission(
                        context,
                        Manifest.permission.ACCESS_FINE_LOCATION
                ) != PackageManager.PERMISSION_GRANTED
        ) {
            handleAttendance(context, 0, 0);
            return;
        }

        fusedLocationClient
                .getLastLocation()
                .addOnSuccessListener(location -> {

                    double lat = 0;
                    double lng = 0;

                    if (location != null) {
                        lat = location.getLatitude();
                        lng = location.getLongitude();
                    }

                    handleAttendance(context, lat, lng);
                });
    }

    private void handleAttendance(Context context, double lat, double lng) {

        SharedPreferences prefs =
                context.getSharedPreferences("app", MODE_PRIVATE);

        int lastClass = prefs.getInt("lastClass", 0);

        String[][] payload = new String[][]{
                {"token", prefs.getString("token", "")},
                {"nr_lekcji", String.valueOf((lastClass - 1) / 2 + 1)},
                {"spoznienie", String.valueOf((lastClass - 1) % 2)},
                {"pozycja", "{\"lat\":" + lat + ", \"lng\":" + lng + "}"}
        };

        System.out.println("PAYLOAD: " + Arrays.deepToString(payload));

        String request = RequestsManager.post(
                prefs.getString("domain", ""),
                new Header[]{
                        new Header("Authorization", "sprawdzObecnosc")
                },
                payload
        );

        System.out.println("REQUEST: " + request);

        String data = prefs.getString("classes", "");

        String[] data1 = data.split("Λ");
        String[][] data2 = new String[data1.length][2];

        for (int i = 0; i < data1.length; i++)
            data2[i] = data1[i].split("λ");

        if (lastClass < data2.length * 2) {

            int classIndex = lastClass / 2;

            int offset =
                    Integer.parseInt(data2[classIndex][0]) % 2 == 0
                            ? 0
                            : Integer.parseInt(data2[classIndex][1]) / 3;

            TimeAlarmScheduler.schedule(
                    context,
                    data2[classIndex][0],
                    offset
            );

            prefs.edit().putInt("lastClass", lastClass + 1).apply();
        }

        System.out.println("DONE SENDING ATTENDANCE");
    }
}