import changeCase from 'change-case'

export default (_, inject) => {
  inject('changeCase', changeCase)
}
