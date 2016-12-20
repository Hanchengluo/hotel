LOCAL_PATH:= $(call my-dir)
include $(CLEAR_VARS)
LOCAL_PACKAGE_NAME := myhotel_launcher
LOCAL_CERTIFICATE := myhotel.pem
LOCAL_SRC_FILES := $(call find-subdir-files, -name "*.js")
LOCAL_SRC_FILES += $(call find-subdir-files, -name "*.css")
LOCAL_SRC_FILES += $(call find-subdir-files, -name "*.png")
LOCAL_SRC_FILES += $(call find-subdir-files, -name "*.jpg")
LOCAL_SRC_FILES += $(call find-subdir-files, -name "*.gif")
LOCAL_SRC_FILES += $(call all-subdir-html-files)
include $(BUILD_WEBAPP)
