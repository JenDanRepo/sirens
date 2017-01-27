#!/bin/sh

sudo mysqldump growlerscenedb Checkins Sirens --result-file=siren_db_load.sql
