LOCAL_PATH:= $(call my-dir)
include $(CLEAR_VARS)
LOCAL_PACKAGE_NAME := hotel_slideshow
LOCAL_CERTIFICATE := launcher.pem
LOCAL_SRC_FILES := $(call find-subdir-files,. -name "*.js")
LOCAL_SRC_FILES += $(call find-subdir-files,. -name "*.css")
LOCAL_SRC_FILES += $(call find-subdir-files,. -name "*.png")
LOCAL_SRC_FILES += $(call find-subdir-files,. -name "*.jpg")
LOCAL_SRC_FILES += $(call find-subdir-files,. -name "*.gif")
LOCAL_SRC_FILES += $(call find-subdir-files,. -name "*.mp3")
LOCAL_SRC_FILES += $(call find-subdir-files,. -name "*.ogg")
LOCAL_SRC_FILES += $(call all-subdir-html-files)
include $(BUILD_WEBAPP)
