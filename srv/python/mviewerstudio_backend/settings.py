import os


class Config:
    CONF_PATH_FROM_MVIEWER = os.getenv("CONF_PATH_FROM_MVIEWER", "apps/store/")
    EXPORT_CONF_FOLDER = os.getenv("EXPORT_CONF_FOLDER", "./store")
    LOG_LEVEL = os.getenv("LOG_LEVEL", "INFO")
