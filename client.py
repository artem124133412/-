# -*- coding: utf-8 -*-
import sys
import requests

if hasattr(sys.stdout, "reconfigure"):
    sys.stdout.reconfigure(encoding="utf-8")

BASE = "http://localhost:8000/index.php"

def fetch_car(brand):
    r = requests.get(BASE, params={"brand": brand}, timeout=5)
    print(f"GET {r.url} -> Код: {r.status_code}")
    
    data = r.json()
    if r.status_code == 404:
        print(f"  Помилка: {data['error']}\n")
    else:
        for m in data["models"]:
            print(f"  Модель: {m['model']:<10} | Тип: {m['type']:<10} | {m['hp']} к.с.")
        print()

print("1) Питаю перелік марок...")
r = requests.get(BASE, timeout=5)
print("Доступні марки:", r.json()["brands"], "\n")

print("2) Питаю моделі BMW...")
fetch_car("BMW")

print("3) Питаю неіснуючу марку (очікую 404)...")
fetch_car("Lada")# -