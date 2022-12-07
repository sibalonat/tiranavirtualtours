import { defineStore } from 'pinia'

export const usePlayerStore = defineStore('player', {

  state: () => {
    return {
      title: '',
      cover: '',
      soundState: ''
    }
  }
})
