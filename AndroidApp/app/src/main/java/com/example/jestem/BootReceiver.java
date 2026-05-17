package com.example.jestem;

import static android.content.Context.MODE_PRIVATE;

import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Build;

public class BootReceiver extends BroadcastReceiver {

    @Override
    public void onReceive(Context context, Intent intent) {

        if (Intent.ACTION_BOOT_COMPLETED.equals(intent.getAction())) {
            AlarmScheduler.scheduleNext6AM(context);

            SharedPreferences prefs = context.getSharedPreferences("app", MODE_PRIVATE);

            if (!prefs.getBoolean("verified", false)) {

                long trigger = prefs.getLong("verificationTimer", System.currentTimeMillis());

                if (trigger < System.currentTimeMillis())
                    context.sendBroadcast(new Intent(context, VerifyToken.class));
                else {
                    AlarmManager alarmManager = (AlarmManager) context.getSystemService(Context.ALARM_SERVICE);

                    if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.S)
                        if (alarmManager.canScheduleExactAlarms())
                            alarmManager.setExact(
                                    AlarmManager.RTC_WAKEUP,
                                    trigger,
                                    PendingIntent.getBroadcast(
                                            context,
                                            0,
                                            new Intent(context, VerifyToken.class),
                                            PendingIntent.FLAG_IMMUTABLE
                                    )
                            );
                }
            }
        }

    }
}