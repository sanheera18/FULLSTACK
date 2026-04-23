package com.example.demo.Controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;

import com.example.demo.Service.Factorial;

@Controller
public class FactController {
	@Autowired
	private Factorial service;
	@GetMapping("/")
	public String show() {
		return "fact";
	}
	@PostMapping("/calculate")
	public String calculate(@RequestParam int n,Model model) {
		long result=service.calfact(n);
		model.addAttribute("number",n);
		model.addAttribute("result",result);
		return "fact";
	}
}
