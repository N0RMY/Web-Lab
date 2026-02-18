package com.example.demo;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PostMapping;

@Controller
public class MainController {

    @GetMapping("/")
    public String showForm(Model model) {
        model.addAttribute("contactForm", new ContactForm());
        return "index";
    }

    @PostMapping("/results")
    public String submitForm(@ModelAttribute("contactForm") ContactForm contactForm, Model model) {
        System.out.println(contactForm);
        model.addAttribute("contactForm", contactForm);
        return "results";
    }
}
