package com.example.jestem;

import static android.content.Context.MODE_PRIVATE;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;

public class SixAMReceiver extends BroadcastReceiver {

    @Override
    public void onReceive(Context context, Intent intent) {
        AlarmScheduler.fireVerifyUpdate(context);

        SharedPreferences prefs = context.getSharedPreferences("app", MODE_PRIVATE);
        String data = RequestsManager.post(
                prefs.getString("domain", ""),
                new Header[]{new Header("Authorization", "wybierzGodzinyUczen")},
                new String[][]{
                        {"token", prefs.getString("token", "")}
                }
        );

        SharedPreferences.Editor editor = prefs.edit();
        editor.putString("classes", data);

        String[] data1 = data.split("Λ");
        String[][] data2 = new String[data1.length][2];
        for (int i = 0; i < data1.length; i++) {
            data2[i] = data1[i].split("λ");
        }

        TimeAlarmScheduler.schedule(context, data2[0][0], 0);

        editor.putInt("lastClass", 1);
        editor.apply();

        AlarmScheduler.scheduleNext6AM(context);
    }
}