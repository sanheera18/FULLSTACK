package com.jobportal.service;

import com.jobportal.model.Application;
import com.jobportal.model.Job;
import com.jobportal.model.User;
import com.jobportal.repository.ApplicationRepository;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;
import java.util.List;
import java.util.Optional;

@Service
public class ApplicationService {

    private final ApplicationRepository applicationRepository;
    private final EmailService emailService;

    public ApplicationService(ApplicationRepository applicationRepository, EmailService emailService) {
        this.applicationRepository = applicationRepository;
        this.emailService = emailService;
    }

    public Application applyForJob(Job job, User student) {
        if (applicationRepository.existsByJobAndStudent(job, student)) {
            throw new RuntimeException("You have already applied for this job.");
        }

        Application application = new Application();
        application.setJob(job);
        application.setStudent(student);
        application.setStatus("APPLIED");
        application.setApplicationDate(LocalDateTime.now());
        
        Application savedApp = applicationRepository.save(application);
        
        // Notify employer
        try {
            emailService.sendSimpleMessage(
                job.getEmployer().getEmail(),
                "New Application for " + job.getTitle(),
                "Student " + student.getName() + " has applied for your job: " + job.getTitle()
            );
        } catch (Exception e) {
            System.out.println("Failed to send email to employer: " + e.getMessage());
        }

        return savedApp;
    }

    public List<Application> getApplicationsByStudent(User student) {
        return applicationRepository.findByStudent(student);
    }

    public List<Application> getApplicationsByJob(Job job) {
        return applicationRepository.findByJob(job);
    }

    public void updateApplicationStatus(Long applicationId, String status) {
        Optional<Application> optionalApp = applicationRepository.findById(applicationId);
        if (optionalApp.isPresent()) {
            Application app = optionalApp.get();
            app.setStatus(status);
            applicationRepository.save(app);

            // Notify student
            try {
                emailService.sendSimpleMessage(
                    app.getStudent().getEmail(),
                    "Application Status Update",
                    "Your application for " + app.getJob().getTitle() + " is now: " + status
                );
            } catch (Exception e) {
                System.out.println("Failed to send email to student: " + e.getMessage());
            }
        }
    }
}
