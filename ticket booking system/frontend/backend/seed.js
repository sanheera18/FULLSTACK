require('dotenv').config();
const mongoose = require('mongoose');
const Event = require('./models/Event');

const INITIAL_EVENTS = [
  {
    eventId: 'e1',
    name: "TechNova 2026",
    department: "Computer Science",
    category: "Technical",
    date: "April 25, 2026",
    time: "09:00 AM - 05:00 PM",
    venue: "Main Auditorium",
    price: 15,
    initialTickets: 100,
    availableTickets: 100,
    description: "The biggest technical fest of the year featuring coding competitions, hackathons, and tech talks.",
    bgImage: "/bg_technical.png",
    location: { lat: 37.7749, lng: -122.4194 } // San Francisco as mock
  },
  {
    eventId: 'e3',
    name: "AI Symposium",
    department: "Artificial Intelligence",
    category: "Technical",
    date: "June 5, 2026",
    time: "11:00 AM - 03:00 PM",
    venue: "Virtual Hall 1",
    price: 10,
    initialTickets: 200,
    availableTickets: 200,
    description: "Learn about the latest trends in Generative AI, Machine Learning, and Neural Networks.",
    bgImage: "/bg_technical.png",
    location: { lat: 40.7128, lng: -74.0060 } // New York as mock
  },
  {
    eventId: 't1',
    name: "Cyber Security CTF",
    department: "Information Technology",
    category: "Technical",
    date: "July 12, 2026",
    time: "08:00 AM - 08:00 PM",
    venue: "Lab Complex B",
    price: 20,
    initialTickets: 150,
    availableTickets: 150,
    description: "A 12-hour Capture The Flag competition. Find vulnerabilities and secure the servers to win cash prizes.",
    bgImage: "/bg_technical.png",
    location: { lat: 51.5074, lng: -0.1278 } // London as mock
  },
  {
    eventId: 'e4',
    name: "Cultural Fiesta",
    department: "Student Council",
    category: "Non-Technical",
    date: "August 15, 2026",
    time: "05:00 PM - 11:00 PM",
    venue: "Open Air Theatre",
    price: 5,
    initialTickets: 500,
    availableTickets: 500,
    description: "An evening of music, dance, and drama performances by various college clubs.",
    bgImage: "/bg_non_technical.png",
    location: { lat: 48.8566, lng: 2.3522 } // Paris as mock
  },
  {
    eventId: 'e6',
    name: "Literature Debate",
    department: "Arts & Humanities",
    category: "Non-Technical",
    date: "October 3, 2026",
    time: "10:00 AM - 01:00 PM",
    venue: "Seminar Hall 2",
    price: 0,
    initialTickets: 150,
    availableTickets: 150,
    description: "Annual debate competition covering contemporary themes in literature and society.",
    bgImage: "/bg_non_technical.png",
    location: { lat: -33.8688, lng: 151.2093 } // Sydney as mock
  },
  {
    eventId: 'nt1',
    name: "Inter-college Sports Meet",
    department: "Physical Education",
    category: "Non-Technical",
    date: "November 20, 2026",
    time: "07:00 AM - 06:00 PM",
    venue: "Main Sports Ground",
    price: 10,
    initialTickets: 1000,
    availableTickets: 1000,
    description: "Join us for track events, football, basketball, and more. Cheer for your department!",
    bgImage: "/bg_non_technical.png",
    location: { lat: 35.6895, lng: 139.6917 } // Tokyo as mock
  },
  {
    eventId: 'e2',
    name: "DesignSprint",
    department: "Design & UX",
    category: "Workshop",
    date: "May 10, 2026",
    time: "10:00 AM - 04:00 PM",
    venue: "Creative Studio",
    price: 25,
    initialTickets: 50,
    availableTickets: 50,
    description: "A 6-hour design sprint challenge for UI/UX enthusiasts. Prototyping tools provided.",
    bgImage: "/bg_workshop.png",
    location: { lat: 34.0522, lng: -118.2437 } // Los Angeles as mock
  },
  {
    eventId: 'e5',
    name: "Robotics Workshop",
    department: "Mechanical Engineering",
    category: "Workshop",
    date: "September 12, 2026",
    time: "09:00 AM - 02:00 PM",
    venue: "Mechatronics Lab",
    price: 30,
    initialTickets: 40,
    availableTickets: 40,
    description: "Hands-on Arduino and Raspberry Pi workshop building line-following robots.",
    bgImage: "/bg_workshop.png",
    location: { lat: 41.8781, lng: -87.6298 } // Chicago as mock
  },
  {
    eventId: 'w1',
    name: "Public Speaking Masterclass",
    department: "Management",
    category: "Workshop",
    date: "December 5, 2026",
    time: "02:00 PM - 05:00 PM",
    venue: "Mini Auditorium",
    price: 15,
    initialTickets: 60,
    availableTickets: 60,
    description: "Learn how to present your ideas confidently. Interactive sessions with industry experts.",
    bgImage: "/bg_workshop.png",
    location: { lat: 1.3521, lng: 103.8198 } // Singapore as mock
  }
];

const User = require('./models/User');
const bcrypt = require('bcryptjs');

const seedData = async () => {
  try {
    // Create Admin User if not exists
    const adminExists = await User.findOne({ email: 'admin@ticketmaster.com' });
    if (!adminExists) {
      const salt = await bcrypt.genSalt(10);
      const hashedPassword = await bcrypt.hash('adminpassword', salt);
      await User.create({
        name: 'Admin',
        email: 'admin@ticketmaster.com',
        password: hashedPassword,
        role: 'admin'
      });
      console.log('Admin User Created!');
    }

    // Only seed events if the collection is completely empty
    const eventCount = await Event.countDocuments();
    if (eventCount === 0) {
      await Event.insertMany(INITIAL_EVENTS);
      console.log('Events Seeded Successfully!');
    } else {
      console.log('Events already exist in database, skipping seed.');
    }
  } catch (err) {
    console.log('Error Seeding Events:', err);
  }
};

module.exports = { seedData };

// If run directly
if (require.main === module) {
  mongoose.connect(process.env.MONGO_URI || 'mongodb://127.0.0.1:27017/ticket-booking-app')
    .then(async () => {
      console.log('MongoDB Connected for Seeding...');
      await seedData();
      process.exit();
    })
    .catch(err => {
      console.log('Error:', err);
      process.exit(1);
    });
}
