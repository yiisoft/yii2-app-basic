import React, { useState, useEffect } from 'react';
import axios from 'axios';
import NewsTable from './NewsTable';
import AddNewsForm from './AddNewsForm';
import ReactModal from 'react-modal';
import {NotificationContainer, NotificationManager} from 'react-notifications';

ReactModal.setAppElement('#root');

function App() {
  const [news, setNews] = useState([]);
  const [showForm, setShowForm] = useState(false);
  const [editingId, setEditingId] = useState(null);

  useEffect(() => {
    handleGetNewsList();
  }, []);

  const handleGetNewsList = () => {
    axios.get('/api/news')
      .then((response) => {
        if (response.data.success) {
          setNews(response.data.result);
        } else {
          NotificationManager.error(response.data.message);
        }
      })
      .catch((error) => {
        NotificationManager.error('Error receiving news.');
      });
  }

  const handleSave = (newNews) => {
    return axios.post('/api/news', newNews)
      .then((response) => {
        if (response.data.success) {
          setNews([...news, response.data.result]);
          NotificationManager.success('The news has been successfully added.');
          setShowForm(false);
        } else {
          NotificationManager.error(response.data.message);
        }
        return new Promise(() => {
          return response.data.success;
        });
      })
      .catch((error) => {
        NotificationManager.error('Error saving news.');
        return new Promise(() => {
          return false;
        });
      });
  };

  const handleDelete = (id) => {
    axios.delete(`/api/news/${id}`)
      .then((response) => {
        if (response.data.success) {
          setNews(news.filter((item) => item.id !== id));
          NotificationManager.success('The news has been successfully deleted.');
        } else {
          NotificationManager.error(response.data.message);
        }
      })
      .catch((error) => {
        NotificationManager.error('Error when deleting news.');
      });
  };

  const handleEdit = (id) => {
    setEditingId(id);
  };

  const handleUpdate = (id, updatedData) => {
    return axios.put(`/api/news/${id}`, updatedData)
      .then((response) => {
        if (response.data.success) {
          const updatedNewsList = news.map((item) =>
            item.id === id ? { ...item, ...response.data.result } : item
          );
          setNews(updatedNewsList);
          setEditingId(null);
          NotificationManager.success('The news has been successfully updated.');
        } else {
          NotificationManager.error(response.data.message);
        }
        return new Promise(() => {
          return response.data.success;
        });
      })
      .catch((error) => {
        NotificationManager.error('Error updating news.');
        return new Promise(() => {
          return false;
        });
      });
  };

  function hideForm() {
    setShowForm(false)
  }

  return (
    <div className="container">
      <NotificationContainer/>
      <button onClick={() => setShowForm(!showForm)}>Add</button>
      <ReactModal
        isOpen={showForm}
        onRequestClose={hideForm}
        className="modal"
        overlayClassName="modal_overlay"
      >
        <AddNewsForm onSave={handleSave} />
      </ReactModal>
      <NewsTable
        news={news}
        onDelete={handleDelete}
        onEdit={handleEdit}
        onUpdate={handleUpdate}
        editingId={editingId}
      />
    </div>
  );
}

export default App;
