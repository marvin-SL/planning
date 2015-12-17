<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Calendar;
use AppBundle\Entity\ClassRoom;
use AppBundle\Entity\Teacher;
use AppBundle\Entity\Subject;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;



class CalendarController extends Controller
{

    public function newAction(Request $request)
    {
        // replace this example code with whatever you need
        $calendar = new Calendar();

        $form = $this->createForm(new CalendarType(), $calendar);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();
        }

        return $this->render('AppBundle:Admin/Calendar:new.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    public function showAction(Request $request)
    {

        $teachers = new Teacher();
        $subjects = new Subject();
        $classRooms = new ClassRoom();

        $teacherRepository = $this->getDoctrine()
        ->getRepository('AppBundle:Teacher');

        $subjectRepository = $this->getDoctrine()
        ->getRepository('AppBundle:Subject');

        $classRoomRepository = $this->getDoctrine()
            ->getRepository('AppBundle:ClassRoom');
        $eventRepository = $this->getDoctrine()
            ->getRepository('AppBundle:Event');

        $classrooms = $classRoomRepository->findAll();
        $subjects = $subjectRepository->findAll();

        $results = [];

        for($i = 0; $i < sizeof($subjects); $i++){
            $results['subject'][$i]['subjectName']=$subjects[$i]->getName();
            //   $results['subject'][]['subjectName'][$subjects[$i]->getName()]['firstname'][] = $teacher->getFirstName();
            foreach ($subjects[$i]->getTeachers() as $teacher){
                for($y = 0; $y < sizeof($subjects[$i]); $y++){

                    $results['subject'][$i]['firstname'][] = $teacher->getFirstName();
                    $results['subject'][$i]['lastname'][] = $teacher->getLastName();
                }
            }
        }

        $query = $eventRepository->createQueryBuilder ( 'e' )->getQuery ()->getResult ();

		$rootNode = new \SimpleXMLElement( "<data></data>" );


		foreach($query as $value){
         //dump($value);die;
                //  $eventNode->addChild("subject", $value->getSubject()->getName()."-".$value->getSubject()->getTeachers()->getFirstName());
                 foreach($value->getSubject()->getTeachers() as $teacher){
                     dump($teacher);
                 }
            $eventNode = $rootNode->addChild('event');
            $eventNode->addChild("start_date", $value->getStartDate()->format('Y-m-d H:i:s'));
            $eventNode->addChild("end_date", $value->getEndDate()->format('Y-m-d H:i:s'));
            $eventNode->addChild("classroom", $value->getClassRoom()->getName());
            $eventNode->addChild("id", $value->getId());

		}
        dump($rootNode->asXML());die;

        $eventRepository = $this->getDoctrine()
        ->getRepository('AppBundle:Event');

        $event = new Event();

        $eventList = $eventRepository->findAll();


        $serializer = $this->get('jms_serializer');
        $context = new SerializationContext();

        $xmlContent = $serializer->serialize($eventList, 'xml', SerializationContext::create()->setGroups(array('xml')));
        //dump($xmlContent);die;
        $path = $this->get('kernel')->getRootDir() . '/../web/data/events2.xml';

        file_put_contents($path,$xmlContent);

        $form = $this->createForm(new EventType(), $event);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
        }


        return $this->render('AppBundle:Admin/Calendar:show.html.twig', array(
            'teachers' => $teachers,
            'subjects' => $subjects,
            'classRooms' => $classrooms,
            'results' => $results,
            'form' => $form->createView(),
        ));
    }

}
