const express = require('express');
const router = express.Router();
const Ticket = require('../models/Ticket');
const Event = require('../models/Event');
const { protect, admin } = require('../middleware/authMiddleware');

// @route   POST /api/bookings
// @desc    Create a new booking
router.post('/', protect, async (req, res) => {
  try {
    const { eventId, numTickets, totalPrice, receiptId } = req.body;

    const event = await Event.findOne({ eventId: eventId });
    if (!event) {
      return res.status(404).json({ message: 'Event not found' });
    }

    if (event.availableTickets < numTickets) {
      return res.status(400).json({ message: 'Not enough tickets available' });
    }

    // Create ticket
    const ticket = await Ticket.create({
      user: req.user._id,
      event: event._id,
      numTickets,
      totalPrice,
      receiptId
    });

    // Update event available tickets
    event.availableTickets -= numTickets;
    await event.save();

    res.status(201).json(ticket);
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
});

// @route   GET /api/bookings/mybookings
// @desc    Get user bookings
router.get('/mybookings', protect, async (req, res) => {
  try {
    const tickets = await Ticket.find({ user: req.user._id }).populate('event');
    res.json(tickets);
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
});

// @route   GET /api/bookings
// @desc    Get all bookings (Admin only)
router.get('/', protect, admin, async (req, res) => {
  try {
    const tickets = await Ticket.find({}).populate('user', 'id name email').populate('event', 'id name eventId');
    res.json(tickets);
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
});

// @route   PUT /api/bookings/:id/status
// @desc    Update booking status
router.put('/:id/status', protect, admin, async (req, res) => {
  try {
    const { status } = req.body;
    const ticket = await Ticket.findById(req.params.id);

    if (!ticket) {
      return res.status(404).json({ message: 'Ticket not found' });
    }

    ticket.status = status;
    const updatedTicket = await ticket.save();

    res.json(updatedTicket);
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
});

module.exports = router;
