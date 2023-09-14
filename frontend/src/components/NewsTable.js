import React, { useState } from 'react';

const NewsTable = ({ news, onDelete, onEdit, onUpdate, editingId }) => {
  const [editedData, setEditedData] = useState({ title: '', description: '', text: '' });

  const handleEditClick = (item) => {
    if (editingId === item.id) {
      onUpdate(item.id, editedData).then((success) => {
        if (success) {
          setEditedData({ title: '', description: '', text: '' });
        }
      });
    } else {
      onEdit(item.id);
      setEditedData({ title: item.title, description: item.description, text: item.text });
    }
  };

  return (
    <table>
      <thead>
      <tr>
        <th className="column_title">Title</th>
        <th className="column_description">Description</th>
        <th className="column_text">Text</th>
        <th className="column_actions">Actions</th>
      </tr>
      </thead>
      <tbody>
      {news.map((item) => (
        <tr key={item.id}>
          <td>
            {editingId === item.id ? (
              <input
                type="text"
                name="title"
                value={editedData.title}
                onChange={(e) => setEditedData({ ...editedData, title: e.target.value })}
              />
            ) : (
              <div>{item.title}</div>
            )}
          </td>
          <td>
            {editingId === item.id ? (
              <input
                type="text"
                name="description"
                value={editedData.description}
                onChange={(e) => setEditedData({ ...editedData, description: e.target.value })}
              />
            ) : (
              <div>{item.description}</div>
            )}
          </td>
          <td>
            {editingId === item.id ? (
              <textarea
                name="text"
                value={editedData.text}
                onChange={(e) => setEditedData({ ...editedData, text: e.target.value })}
              />
            ) : (
              <div>{item.text}</div>
            )}
          </td>
          <td className="actions">
            <button className="delete" onClick={() => onDelete(item.id)}>Delete</button>
            <button className={editingId === item.id ? 'update' : 'edit'} onClick={() => handleEditClick(item)}>
              {editingId === item.id ? 'Update' : 'Edit'}
            </button>
          </td>
        </tr>
      ))}
      </tbody>
    </table>
  );
};

export default NewsTable;
