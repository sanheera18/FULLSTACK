const express = require('express');
const router = express.Router();
const Event = require('../models/Event');
const { protect, admin } = require('../middleware/authMiddleware');

// @route   GET /api/events
// @desc    Get all events
router.get('/', async (req, res) => {
  try {
    const events = await Event.find({});
    res.json(events);
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
});

// @route   GET /api/events/:id
// @desc    Get event by eventId
router.get('/:id', async (req, res) => {
  try {
    const event = await Event.findOne({ eventId: req.params.id });
    if (event) {
      res.json(event);
    } else {
      res.status(404).json({ message: 'Event not found' });
    }
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
});

// @route   POST /api/events
// @desc    Create an event
router.post('/', protect, admin, async (req, res) => {
  try {
    const event = await Event.create(req.body);
    res.status(201).json(event);
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
});

// @route   PUT /api/events/:id
// @desc    Update an event
router.put('/:id', protect, admin, async (req, res) => {
  try {
    const event = await Event.findOneAndUpdate({ eventId: req.params.id }, req.body, { new: true });
    if (!event) {
      // Also try by mongo _id
      const eventById = await Event.findByIdAndUpdate(req.params.id, req.body, { new: true });
      if (!eventById) {
        return res.status(404).json({ message: 'Event not found' });
      }
      return res.json(eventById);
    }
    res.json(event);
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
});

// @route   DELETE /api/events/:id
// @desc    Delete an event
router.delete('/:id', protect, admin, async (req, res) => {
  try {
    let event = await Event.findOneAndDelete({ eventId: req.params.id });
    if (!event) {
      event = await Event.findByIdAndDelete(req.params.id);
      if (!event) {
        return res.status(404).json({ message: 'Event not found' });
      }
    }
    res.json({ message: 'Event removed' });
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
});

module.exports = router;
