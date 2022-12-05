import { defineStore } from 'pinia'

export const usePlayerStore = defineStore('player', {

  state: () => {
    return {
      title: '',
      author: '',
      cover: '',
      soundState: ''
    }
  }
})
