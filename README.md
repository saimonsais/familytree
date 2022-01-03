# familytree
A pet project - Just for fun.


- TABLE:people
  - ppl-id
  - ppl-firstname
  - ppl-lastname
  - ppl-dateborn
  - ppl-datedeath
  - ppl-desc
- Table:picture
  - pic-id
  - pic-url
  - pic-person (ppl-id)
  - pic-person-location
- Table:event-type
  - evtype-id
  - evtype-name
- Table:event-marriage
  - ev-mar-id
  - ev-mar-husband (ppl-id)
  - ev-mar-wife (ppl-id)
  - ev-mar-datestart
  - ev-mar-dateend
- Table:event-children
  - ev-child-id 
  - ev-child-father (ppl-id)
  - ev-child-mother (ppl-id)
  - ev-child-kid (ppl-id)
- Table:event-global
  - ev-glob-id
  - ev-glob-type (evtype-id)
  - ev-glob-person (ppl-id)
  - ev-glob-date
  - ev-glob-desc
