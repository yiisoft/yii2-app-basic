import React, { useState } from 'react';

const AddNewsForm = ({ onSave }) => {
  const [formData, setFormData] = useState({ title: '', description: '', text: '' });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    onSave(formData).then((success) => {
      if (success) {
        setFormData({ title: '', description: '', text: '' });
      }
    });
  };

  return (
    <div className="form-container">
      <form onSubmit={handleSubmit}>
        <div>
          <label>Title:</label>
          <input type="text" name="title" value={formData.title} onChange={handleChange} />
        </div>
        <div>
          <label>Description:</label>
          <input type="text" name="description" value={formData.description} onChange={handleChange} />
        </div>
        <div>
          <label>Text:</label>
          <textarea name="text" value={formData.text} onChange={handleChange} />
        </div>
        <button type="submit">Save</button>
      </form>
    </div>
  );
};

export default AddNewsForm;
