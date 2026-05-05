package com.jobportal.controller;

import com.jobportal.model.Application;
import com.jobportal.model.Job;
import com.jobportal.model.User;
import com.jobportal.service.ApplicationService;
import com.jobportal.service.JobService;
import com.jobportal.service.UserService;
import org.springframework.security.core.Authentication;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.multipart.MultipartFile;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import java.io.IOException;
import java.util.List;
import java.util.stream.Collectors;

@Controller
public class DashboardController {

    private final JobService jobService;
    private final ApplicationService applicationService;
    private final UserService userService;

    public DashboardController(JobService jobService, ApplicationService applicationService, UserService userService) {
        this.jobService = jobService;
        this.applicationService = applicationService;
        this.userService = userService;
    }

    @GetMapping("/employer/dashboard")
    public String employerDashboard(Model model, Authentication authentication) {
        User employer = userService.findByUsername(authentication.getName()).orElseThrow();
        List<Job> postedJobs = jobService.getJobsByEmployer(employer);
        
        // Flatten applications for all jobs posted by this employer
        List<Application> allApplications = postedJobs.stream()
                .flatMap(job -> applicationService.getApplicationsByJob(job).stream())
                .sorted((a1, a2) -> a1.getApplicationDate().compareTo(a2.getApplicationDate()))
                .collect(Collectors.toList());

        model.addAttribute("jobs", postedJobs);
        model.addAttribute("applications", allApplications);
        model.addAttribute("totalJobs", postedJobs.size());
        model.addAttribute("totalApplications", allApplications.size());
        
        return "employer-dashboard";
    }

    @GetMapping("/student/dashboard")
    public String studentDashboard(Model model, Authentication authentication) {
        User student = userService.findByUsername(authentication.getName()).orElseThrow();
        List<Application> applications = applicationService.getApplicationsByStudent(student);
        
        model.addAttribute("user", student);
        model.addAttribute("applications", applications);
        model.addAttribute("totalApplications", applications.size());
        
        return "student-dashboard";
    }

    @PostMapping("/student/resume/upload")
    public String uploadResume(@RequestParam("file") MultipartFile file, Authentication authentication, RedirectAttributes redirectAttributes) {
        try {
            User student = userService.findByUsername(authentication.getName()).orElseThrow();
            userService.saveResume(student, file);
            redirectAttributes.addFlashAttribute("message", "Resume uploaded successfully!");
        } catch (IOException e) {
            redirectAttributes.addFlashAttribute("error", "Failed to upload resume.");
        }
        return "redirect:/student/dashboard";
    }
}
