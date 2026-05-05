require('dotenv').config();
const express = require('express');
const cors = require('cors');
const mongoose = require('mongoose');

const authRoutes = require('./routes/authRoutes');
const eventRoutes = require('./routes/eventRoutes');
const bookingRoutes = require('./routes/bookingRoutes');

const app = express();

// Middleware
app.use(cors());
app.use(express.json());

const { MongoMemoryServer } = require('mongodb-memory-server');

const connectDB = async () => {
  try {
    let uri = process.env.MONGO_URI || 'mongodb://127.0.0.1:27017/ticket-booking-app';
    if (process.env.USE_MEMORY_DB === 'true') {
      const mongoServer = await MongoMemoryServer.create();
      uri = mongoServer.getUri();
      console.log('Using In-Memory MongoDB');
      console.log(`\n========================================================`);
      console.log(`To view your database, open MongoDB Compass and connect to:`);
      console.log(`URI: ${uri}`);
      console.log(`========================================================\n`);
    }
    await mongoose.connect(uri);
    console.log('MongoDB Connected...');
    
    // Auto-seed the database if it is empty
    const seedScript = require('./seed');
    await seedScript.seedData();
  } catch (err) {
    console.log('MongoDB Connection Error:', err);
  }
};
connectDB();

// Routes
app.use('/api/auth', authRoutes);
app.use('/api/events', eventRoutes);
app.use('/api/bookings', bookingRoutes);

app.get('/', (req, res) => {
  res.send('API is running...');
});

const PORT = process.env.PORT || 5000;
app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
