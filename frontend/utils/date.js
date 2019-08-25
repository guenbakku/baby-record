/**
 *
 * @param {*} from
 * @param {*} to
 */
export function diffDate(from, to) {
  const fromObj = new Date(from)
  const toObj = new Date(to)

  if (toObj < fromObj) {
    throw new Error('toDate must be equal or greater than fromDate')
  }

  const yearFrom = fromObj.getYear()
  const monthFrom = fromObj.getMonth()
  const dateFrom = fromObj.getDate()

  const yearTo = toObj.getYear()
  const monthTo = toObj.getMonth()
  const dateTo = toObj.getDate()

  let year = 0
  let month = 0
  let date = 0
  year = yearTo - yearFrom

  if (monthTo >= monthFrom) {
    month = monthTo - monthFrom
  } else {
    year--
    month = 12 + monthTo - monthFrom
  }

  if (dateTo >= dateFrom) {
    date = dateTo - dateFrom
  } else {
    month--
    date = lastDayOfMonth(yearFrom, monthFrom + 1) + dateTo - dateFrom

    if (month < 0) {
      month = 11
      year--
    }
  }

  return [year, month, date]
}

/**
 * Return last day of specific month and year
 * @param {int} year
 * @param {int} month: number between 1~12
 */
export function lastDayOfMonth(year, month) {
  if (month < 1 || month > 12) {
    throw new Error('month must be an interger between 1 and 12')
  }

  return new Date(year, month, 0).getDate()
}
