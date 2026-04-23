package com.example.demo.Service;

import org.springframework.stereotype.Service;

@Service
public class Factorial {
	public long calfact(int n) {
		long fact=1;
		for(int i=1;i<=n;i++) {
			fact*=i;
		}
		return fact;
	}
}
