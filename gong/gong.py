#!/usr/bin/env python
# -*- coding: latin-1 -*-

import cgitb
import RPi.GPIO as GPIO
import time

cgitb.enable();
servo_pin = 12  # gpio18
depart = 7.5 
arrivee = 10 
var = 0

GPIO.setmode(GPIO.BOARD)  # notation board plutôt que BCM
GPIO.setup(servo_pin, GPIO.OUT)  # pin configurée en sortie
GPIO.setup(16, GPIO.OUT)
pwm = GPIO.PWM(servo_pin, 50)  # pwm à une fréquence de 50 Hz

position = depart   # on commence à la position de départ

# Boucle LED VERTE
while var < 2:
        GPIO.output(16,GPIO.HIGH)
        time.sleep(0.1)
        print(var)
        var = var + 1
        GPIO.output(16,GPIO.LOW)
        time.sleep(0.2)   

pwm.start(depart)  # on commence le signal pwm
time.sleep(0.5)              
pwm.ChangeDutyCycle(2.5)
time.sleep(0.5)
pwm.ChangeDutyCycle(depart)
time.sleep(0.5)
pwm.stop
