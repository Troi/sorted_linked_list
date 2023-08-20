“Implement a library providing SortedLinkedList
(linked list that keeps values sorted). It should be
able to hold string or int values, but not both. Try to
think about what you'd expect from such library as a
user in terms of usability and best practices, and
apply those.”

We are looking forward to seeing your work, mindset, skill set,
experiences. Enjoy.

My Solution
===
I decided to hide Linked nature of the list from List user and implemented iterator interface
to provide foreach use.

If I had time to make it perfect, I would make more implementations.

Possible improvement
===
I was thinking about make another implementation of SortedList with indexing table (index=>pointer to Item)
Map of indexes (size M) should speed up inserting and getting values M-times. I would let user choose the size of table
or choose automatically to size of log(N). I guess it would change speed of insert from O(N) to O(N/log(N)).
But implement this is behind the scope of this task.
