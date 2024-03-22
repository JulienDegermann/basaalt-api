SHELL := /bin/bash

cities:
	symfony console app:import-cities
.PHONY: cities
