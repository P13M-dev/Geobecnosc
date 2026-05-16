import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.os.Build;
import android.provider.Settings;

import com.example.jestem.RunAfterX;

//AlarmManager alarmManager = (AlarmManager) getSystemService(Context.ALARM_SERVICE);
//
//Intent intent = new Intent(this, RunAfterX.class);
//
//PendingIntent pendingIntent = PendingIntent.getBroadcast(this, 0, intent, PendingIntent.FLAG_IMMUTABLE);
//
//        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.S) {
//        if (!alarmManager.canScheduleExactAlarms()) {
//Intent requestPermissions = new Intent(Settings.ACTION_REQUEST_SCHEDULE_EXACT_ALARM);
//
//startActivity(requestPermissions);
//            }
//                    }
//
////        Calendar calendar = Calendar.getInstance();
////
////        calendar.set(Calendar.HOUR_OF_DAY, 15);
////        calendar.set(Calendar.MINUTE, 40);
////        calendar.set(Calendar.SECOND, 0);
//long trigger = System.currentTimeMillis() + 1000;
//
//        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.S) if (alarmManager.canScheduleExactAlarms())
//        alarmManager.setExact(
//        AlarmManager.RTC_WAKEUP,
//        trigger,
//        pendingIntent
//        );