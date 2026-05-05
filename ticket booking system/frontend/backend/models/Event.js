const mongoose = require('mongoose');

const eventSchema = new mongoose.Schema({
  eventId: { type: String, required: true, unique: true },
  name: { type: String, required: true },
  department: { type: String, required: true },
  category: { type: String, required: true },
  date: { type: String, required: true },
  time: { type: String, required: true },
  venue: { type: String, required: true },
  location: {
    lat: { type: Number },
    lng: { type: Number }
  },
  price: { type: Number, required: true },
  initialTickets: { type: Number, required: true },
  availableTickets: { type: Number, required: true },
  description: { type: String, required: true },
  bgImage: { type: String }
}, { timestamps: true });

module.exports = mongoose.model('Event', eventSchema);
