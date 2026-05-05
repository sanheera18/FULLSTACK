package com.jobportal.controller;

import com.jobportal.model.Job;
import com.jobportal.model.User;
import com.jobportal.service.JobService;
import com.jobportal.service.UserService;
import jakarta.validation.Valid;
import org.springframework.security.core.Authentication;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.*;

@Controller
public class JobController {

    private final JobService jobService;
    private final UserService userService;

    public JobController(JobService jobService, UserService userService) {
        this.jobService = jobService;
        this.userService = userService;
    }

    @GetMapping("/")
    public String home() {
        return "index";
    }

    @GetMapping("/jobs")
    public String listJobs(Model model, @RequestParam(value = "keyword", required = false) String keyword) {
        model.addAttribute("jobs", jobService.searchJobs(keyword));
        model.addAttribute("keyword", keyword);
        return "jobs";
    }

    @GetMapping("/jobs/{id}")
    public String jobDetails(@PathVariable Long id, Model model) {
        Job job = jobService.getJobById(id)
                .orElseThrow(() -> new IllegalArgumentException("Invalid job Id:" + id));
        model.addAttribute("job", job);
        return "job-details";
    }

    @GetMapping("/employer/jobs/new")
    public String showPostJobForm(Model model) {
        model.addAttribute("job", new Job());
        return "post-job";
    }

    @PostMapping("/employer/jobs")
    public String postJob(@Valid @ModelAttribute("job") Job job, BindingResult bindingResult, Authentication authentication) {
        if (bindingResult.hasErrors()) {
            return "post-job";
        }
        
        User employer = userService.findByUsername(authentication.getName()).orElseThrow();
        jobService.saveJob(job, employer);
        return "redirect:/employer/dashboard";
    }
    
    @PostMapping("/employer/jobs/{id}/delete")
    public String deleteJob(@PathVariable Long id) {
        jobService.deleteJob(id);
        return "redirect:/employer/dashboard";
    }
}
