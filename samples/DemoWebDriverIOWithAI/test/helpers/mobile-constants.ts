/** Google Messages (override via MESSAGES_APP_PACKAGE for AOSP / other builds). */
export const MESSAGES_PACKAGE =
  process.env.MESSAGES_APP_PACKAGE ?? 'com.google.android.apps.messaging'

/** Launcher activity for {@link MESSAGES_PACKAGE} (must match Appium caps). */
export const MESSAGES_ACTIVITY =
  process.env.MESSAGES_APP_ACTIVITY ??
  'com.google.android.apps.messaging.ui.ConversationListActivity'
