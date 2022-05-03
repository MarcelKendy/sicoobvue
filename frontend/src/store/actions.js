import db from '../services/localbase'

export default {
    addUser({commit}, data) {
      if (data) {
        db.collection('user').add({
          id: data.id, 
          name: data.name, 
          full_name: data.full_name,
          cpf: data.cpf, 
          email: data.email,
          accesses: data.accesses,
          password: data.password
        }).then(() => {
          commit('getUser')
        })
      }
    },
    addTask({commit}, data) {
        if (data.title && data.subtitle) {
          db.collection('tasks').add({
            id: new Date().getTime(), 
            title: data.title, 
            subtitle: data.subtitle, 
            done: false
          }).then(() => {
            commit('getTasks')
          })
        }
      },
      editTask({commit}, data) {
        if (data.title && data.subtitle) { 
          db.collection('tasks').doc({
            id: data.id, 
          }).update({
            title: data.title, 
            subtitle: data.subtitle 
          }).then(() => {
            commit('getTasks')
          })
        }
      },
      doneTask({commit}, data) {
        if (data) { 
          db.collection('tasks').doc({
            id: data.id, 
          }).update({
            done: !data.done 
          }).then(() => {
            commit('getTasks')
          })
        }
      },
      login({commit}, data) {
        if (data) { 
              db.collection('user').add({
                id: data.id, 
                name: data.name, 
                full_name: data.full_name,
                cpf: data.cpf, 
                email: data.email,
                accesses: data.accesses,
                password: data.password
              }, 'logged_token').then(() => {
                commit('getUser')
              })
        }
      }
}