package com.jobportal.config;

import com.jobportal.model.Job;
import com.jobportal.model.User;
import com.jobportal.repository.JobRepository;
import com.jobportal.repository.UserRepository;
import org.springframework.boot.CommandLineRunner;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Component;

import java.util.Arrays;
import java.util.List;

@Component
public class DatabaseSeeder implements CommandLineRunner {

    private final JobRepository jobRepository;
    private final UserRepository userRepository;
    private final PasswordEncoder passwordEncoder;

    public DatabaseSeeder(JobRepository jobRepository, UserRepository userRepository, PasswordEncoder passwordEncoder) {
        this.jobRepository = jobRepository;
        this.userRepository = userRepository;
        this.passwordEncoder = passwordEncoder;
    }

    @Override
    public void run(String... args) throws Exception {
        if (userRepository.findByUsername("admin").isEmpty()) {
            User newAdmin = new User();
            newAdmin.setUsername("admin");
            newAdmin.setPassword(passwordEncoder.encode("admin123"));
            newAdmin.setName("System Admin");
            newAdmin.setEmail("admin@example.com");
            newAdmin.setRole("ROLE_ADMIN");
            userRepository.save(newAdmin);
        }

        if (userRepository.findByUsername("mockemployer").isEmpty()) {
            User newEmployer = new User();
            newEmployer.setUsername("mockemployer");
            newEmployer.setPassword(passwordEncoder.encode("password123"));
            newEmployer.setName("Mock Employer");
            newEmployer.setEmail("mockemployer@example.com");
            newEmployer.setRole("ROLE_EMPLOYER");
            User employer = userRepository.save(newEmployer);

            List<Job> mockJobs = Arrays.asList(
                    createJob("Software Engineer", "Develop and maintain web applications using Java and Spring Boot.", "IT & Software", "New York, NY", "Java, Spring Boot, SQL", "$80,000 - $120,000", employer),
                    createJob("Frontend Developer", "Build responsive UIs using React and Bootstrap.", "IT & Software", "San Francisco, CA", "React, JavaScript, HTML, CSS", "$90,000 - $130,000", employer),
                    createJob("Data Analyst", "Analyze business data and create actionable reports.", "Data Science", "Remote", "SQL, Python, Tableau", "$60,000 - $90,000", employer),
                    createJob("Product Manager", "Lead product development and define project requirements.", "Management", "Austin, TX", "Agile, Jira, Leadership", "$100,000 - $150,000", employer),
                    createJob("UI/UX Designer", "Design user-friendly interfaces and improve user experience.", "Design", "London, UK", "Figma, Adobe XD, Sketch", "$70,000 - $100,000", employer),
                    createJob("Backend Engineer", "Design and optimize database architectures and APIs.", "IT & Software", "Berlin, Germany", "Node.js, MongoDB, Express", "$85,000 - $125,000", employer),
                    createJob("DevOps Engineer", "Manage cloud infrastructure and deployment pipelines.", "IT & Software", "Remote", "AWS, Docker, Kubernetes", "$95,000 - $140,000", employer),
                    createJob("Marketing Specialist", "Develop and execute digital marketing strategies.", "Marketing", "Chicago, IL", "SEO, Content Marketing, Google Analytics", "$50,000 - $75,000", employer),
                    createJob("Sales Executive", "Drive revenue growth by acquiring new clients.", "Sales", "Miami, FL", "B2B Sales, CRM, Negotiation", "$60,000 - $100,000", employer),
                    createJob("Customer Support", "Assist customers with inquiries and troubleshoot issues.", "Customer Service", "Remote", "Communication, Zendesk, Empathy", "$40,000 - $55,000", employer),
                    createJob("HR Manager", "Oversee recruitment, employee relations, and company culture.", "Human Resources", "Seattle, WA", "Recruiting, Onboarding, Conflict Resolution", "$75,000 - $110,000", employer),
                    createJob("Mobile App Developer", "Create iOS and Android applications.", "IT & Software", "Toronto, Canada", "Swift, Kotlin, Flutter", "$80,000 - $120,000", employer),
                    createJob("Data Scientist", "Apply machine learning models to solve business problems.", "Data Science", "Remote", "Python, R, Machine Learning", "$110,000 - $160,000", employer),
                    createJob("Graphic Designer", "Create visual content for print and digital media.", "Design", "Los Angeles, CA", "Photoshop, Illustrator, InDesign", "$55,000 - $80,000", employer),
                    createJob("Business Analyst", "Bridge the gap between IT and the business using data analytics.", "Management", "Boston, MA", "Excel, Power BI, SQL", "$70,000 - $105,000", employer)
            );
            
            jobRepository.saveAll(mockJobs);
        }
    }

    private Job createJob(String title, String description, String category, String location, String skillsRequired, String salary, User employer) {
        Job job = new Job();
        job.setTitle(title);
        job.setDescription(description);
        job.setCategory(category);
        job.setLocation(location);
        job.setSkillsRequired(skillsRequired);
        job.setSalary(salary);
        job.setEmployer(employer);
        return job;
    }
}
