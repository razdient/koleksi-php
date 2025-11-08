<?php
// ======================
// INTERFACE DEFINITIONS
// ======================

// Koleksi umum
interface CollectionInterface {
    public function add($item);
    public function remove($item);
    public function getAll();
}

// List (seperti array)
interface ListInterface extends CollectionInterface {
    public function get($index);
}

// Antrian (FIFO)
interface QueueInterface extends CollectionInterface {
    public function enqueue($item);
    public function dequeue();
}

// Peta (key-value)
interface MapInterface {
    public function put($key, $value);
    public function get($key);
    public function removeKey($key);
}

// Iterator (perulangan)
interface IteratorInterface {
    public function hasNext();
    public function next();
}

// ======================
// IMPLEMENTATIONS
// ======================

// ArrayList = daftar dinamis
class ArrayList implements ListInterface, IteratorInterface {
    private $items = [];
    private $position = 0;

    public function add($item) {
        $this->items[] = $item;
    }

    public function remove($item) {
        $index = array_search($item, $this->items);
        if ($index !== false) unset($this->items[$index]);
    }

    public function getAll() {
        return $this->items;
    }

    public function get($index) {
        return $this->items[$index] ?? null;
    }

    // Iterator
    public function hasNext() {
        return $this->position < count($this->items);
    }

    public function next() {
        return $this->items[$this->position++];
    }
}

// LinkedList (sama saja untuk contoh ini)
class LinkedList extends ArrayList {}

// Stack (LIFO)
class Stack extends ArrayList {
    public function push($item) {
        $this->add($item);
    }
    public function pop() {
        return array_pop($this->getAll());
    }
}

// Queue (FIFO)
class Queue implements QueueInterface {
    private $items = [];

    public function enqueue($item) {
        array_push($this->items, $item);
    }

    public function dequeue() {
        return array_shift($this->items);
    }

    public function add($item) { $this->enqueue($item); }
    public function remove($item) {}
    public function getAll() { return $this->items; }
}

// HashMap (key-value)
class HashMap implements MapInterface {
    private $map = [];

    public function put($key, $value) { $this->map[$key] = $value; }
    public function get($key) { return $this->map[$key] ?? null; }
    public function removeKey($key) { unset($this->map[$key]); }
    public function getAll() { return $this->map; }
}

// ======================
// TESTING
// ======================

echo "=== ArrayList ===\n";
$list = new ArrayList();
$list->add("Apple");
$list->add("Banana");
$list->add("Cherry");
print_r($list->getAll());

echo "\n=== Stack ===\n";
$stack = new Stack();
$stack->push("First");
$stack->push("Second");
echo $stack->pop() . " keluar dari Stack\n";

echo "\n=== Queue ===\n";
$q = new Queue();
$q->enqueue("A");
$q->enqueue("B");
$q->enqueue("C");
echo $q->dequeue() . " keluar dari Queue\n";

echo "\n=== HashMap ===\n";
$map = new HashMap();
$map->put("nim", "230101001");
$map->put("nama", "Rasta");
print_r($map->getAll());
